import { User, Recipe, Category } from '../models/index.js';
import fs from 'fs';
import path from 'path';
import { IncomingForm } from 'formidable';

async function home(req, res) {
    try {
        const recipes = await Recipe.findAll({
            include: [
                { model: Category },
                { model: User }
            ],
            order: [['created_at', 'DESC']],
            limit: 3
        });

        return res.render('index', {
            recipes
        });

    } catch (error) {
        console.error('Erro ao carregar receitas da home:', error);

        return res.status(500).render('errors', {
            title: 'Erro ao carregar a página inicial.',
            message: 'Ocorreu um erro ao carregar a página inicial, tente novamente.'
        });
    }
}

async function showProfile(req, res) {
    const user = await User.findByPk(req.session.userId);

    const recipesPerPage = 6;

    const currentPage = Math.max(
        1,
        parseInt(req.query.page, 10) || 1
    );

    const { count, rows: recipes } = await Recipe.findAndCountAll({
        where: {
            user_id: req.session.userId
        },
        include: [
            { model: Category }
        ],
        order: [['created_at', 'DESC']],
        limit: recipesPerPage,
        offset: (currentPage - 1) * recipesPerPage
    });

    const totalPages = Math.ceil(count / recipesPerPage);

    const errors = req.session.editErrors || {};
    const values = req.session.editValues || {};
    const openEditModal = req.session.openEditModal || false;
    const message = req.session.message;

    delete req.session.editErrors;
    delete req.session.editValues;
    delete req.session.openEditModal;
    delete req.session.message;

    return res.render('user/profile', {
        user,
        recipes,
        errors,
        values,
        openEditModal,
        message,
        currentPage,
        totalPages
    });
}


async function editUser(req, res) {

    const form = new IncomingForm({
        allowEmptyFiles: true,
        minFileSize: 0,
        maxFiles: 1,
        maxFileSize: 5 * 1024 * 1024
    });

    form.parse(req, async (err, fields, files) => {
        if (err) {
            return res.status(500).render('errors', {
                title: 'Erro ao receber formulário.',
                message: 'Ocorreu um erro ao receber o formulário, tente novamente.'
            });
        }

        try {
            const user = await User.findByPk(req.session.userId);

            if (!user) {
                return res.status(404).render('errors', {
                    title: 'Usuário não encontrado',
                    message: 'Não foi possível localizar sua conta.'
                });
            }

            if (typeof fields.name?.[0] !== 'string' || typeof fields.email?.[0] !== 'string') {
                req.session.editErrors = {
                    general: 'Dados inválidos.'
                };

                req.session.editValues = {};
                req.session.openEditModal = true;

                return res.redirect('/profile');
            }

            const name = fields.name[0];
            const email = fields.email[0];

            const errors = {};
            const photo = files.photo?.[0];

            const normalizedName = name.trim();
            const normalizedEmail = email.trim().toLowerCase();

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            if (!normalizedName) {
                errors.name = 'O nome é obrigatório.';
            } else if (normalizedName.length > 100) {
                errors.name = 'O nome deve ter no máximo 100 caracteres.';
            }

            if (!normalizedEmail) {
                errors.email = 'O e-mail é obrigatório.';
            } else if (normalizedEmail.length > 255 || !emailRegex.test(normalizedEmail)
            ) {
                errors.email = 'E-mail inválido.';
            }

            if (!errors.email) {
                const existingUser = await User.findOne({
                    where: { email: normalizedEmail }
                });

                if (existingUser && existingUser.id !== user.id) {
                    errors.email = 'E-mail já cadastrado.';
                }
            }

            if (photo && photo.originalFilename && photo.size > 0 && !['image/jpeg', 'image/png', 'image/webp'].includes(photo.mimetype)) {
                errors.photo = 'Selecione uma imagem JPG, PNG ou WEBP.';
            }

            if (Object.keys(errors).length > 0) {
                req.session.editErrors = errors;
                req.session.editValues = {
                    name: normalizedName,
                    email: normalizedEmail
                };
                req.session.openEditModal = true;

                return res.redirect('/profile');
            }

            user.name = normalizedName;
            user.email = normalizedEmail;

            if (photo && photo.originalFilename && photo.size > 0) {
                const oldPhoto = user.photo;
                const oldPath = photo.filepath;
                const ext = path.extname(photo.originalFilename);
                const newFileName = photo.newFilename + ext;
                const folder = path.join(process.cwd(), 'public', 'uploads');
                await fs.promises.mkdir(folder, { recursive: true });
                const newPath = path.join(folder, newFileName);

                await fs.promises.rename(oldPath, newPath);

                user.photo = `/uploads/${newFileName}`;

                await user.save();

                req.session.username = user.name;
                req.session.userPhoto = `/uploads/${newFileName}`;

                if (oldPhoto && oldPhoto.startsWith('/uploads/')) {
                    const oldPhotoPath = path.join(process.cwd(), 'public', oldPhoto.replace(/^\/+/, ''));
                    await fs.promises.unlink(oldPhotoPath).catch(err => {
                        if (err.code !== 'ENOENT') {
                            console.error('Erro ao remover foto antiga:', err);
                        }
                    });
                }

            } else {
                await user.save();
                req.session.username = normalizedName;
            }

            return res.redirect('/profile');

        } catch (err) {
            return res.status(500).render('errors', {
                title: 'Erro ao atualizar perfil',
                message: 'Não foi possível atualizar seu perfil, tente novamente.'
            });
        }
    });
}

async function deleteUser(req, res) {
    try {
        const user = await User.findByPk(req.session.userId);

        if (!user) {
            return res.status(404).render('errors', {
                title: 'Usuário não encontrado',
                message: 'Não foi possível localizar sua conta.'
            });
        }

        if (user.photo && user.photo.startsWith('/uploads/')) {
            const photoPath = path.join(process.cwd(), 'public', user.photo.replace(/^\/+/, ''));

            await fs.promises.unlink(photoPath).catch(err => {
                if (err.code !== 'ENOENT') {
                    console.error('Erro ao remover foto de perfil:', err);
                }
            });
        }

        await user.destroy();

        req.session.destroy((err) => {
            if (err) {
                return res.status(500).render('errors', {
                    title: 'Não conseguimos encerrar sua sessão.',
                    message: 'Ocorreu um problema ao sair da sua conta. Tente novamente.'
                });
            }

            return res.redirect('/');
        });

    } catch (error) {
        return res.status(500).render('errors', {
            title: 'Erro ao excluir conta',
            message: 'Não foi possível excluir sua conta. Tente novamente.'
        });
    }
}



export {
    home,
    showProfile,
    editUser,
    deleteUser
};
