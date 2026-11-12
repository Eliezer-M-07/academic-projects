import { User } from '../models/index.js';
import bcrypt from 'bcrypt';
import { IncomingForm } from 'formidable';
import path from 'path';
import fs from 'fs';

function showRegister(req, res) {
    if (req.session.userId) {
        return res.redirect('/');
    }

    const errors = req.session.registerErrors || {};
    const values = req.session.registerValues || {};
    const message = req.session.message;

    delete req.session.registerErrors;
    delete req.session.registerValues;
    delete req.session.message;

    return res.render('auth/register', {
        errors,
        values,
        message
    });
}

function showLogin(req, res) {
    if (req.session.userId) {
        return res.redirect('/');
    }

    const errors = req.session.loginErrors || {};
    const values = req.session.loginValues || {};
    const message = req.session.message;

    delete req.session.loginErrors;
    delete req.session.loginValues;
    delete req.session.message;

    return res.render('auth/login', {
        errors,
        values,
        message
    });
}



async function registerUser(req, res) {

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
            const name = fields.name?.[0];
            const email = fields.email?.[0];
            const password = fields.password?.[0];
            const passwordConfirm = fields.passwordConfirm?.[0];

            if (
                typeof name !== 'string' ||
                typeof email !== 'string' ||
                typeof password !== 'string' ||
                typeof passwordConfirm !== 'string'
            ) {
                req.session.registerErrors = {
                    general: 'Dados inválidos.'
                };

                req.session.registerValues = {
                    name: '',
                    email: ''
                };

                return res.redirect('/register');
            }

            const errors = {};

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
            } else if (normalizedEmail.length > 255 || !emailRegex.test(normalizedEmail)) {
                errors.email = 'E-mail inválido.';
            }

            if (password.length < 8) {
                errors.password = 'A senha deve ter pelo menos 8 caracteres.';
            }

            if (password !== passwordConfirm) {
                errors.passwordConfirm = 'As senhas não coincidem.';
            }

            const photo = files.photo?.[0];

            if (photo && photo.originalFilename && photo.size > 0) {
                if (!['image/jpeg', 'image/png', 'image/webp'].includes(photo.mimetype)) {
                    errors.photo = 'Selecione uma imagem JPG, PNG ou WEBP.';
                }
            }

            if (!errors.email) {
                const existingUser = await User.findOne({
                    where: { email: normalizedEmail }
                });

                if (existingUser) {
                    errors.email = 'E-mail já cadastrado.';
                }
            }

            if (Object.keys(errors).length > 0) {
                req.session.registerErrors = errors;

                req.session.registerValues = {
                    name: normalizedName,
                    email: normalizedEmail
                };

                return res.redirect('/register');
            }

            let photoPath = '/images/default-profile.webp';

            if (photo && photo.originalFilename && photo.size > 0) {
                const ext = path.extname(photo.originalFilename);
                const newFileName = photo.newFilename + ext;
                const folder = path.join(process.cwd(), 'public', 'uploads');

                await fs.promises.mkdir(folder, { recursive: true });

                const newPath = path.join(folder, newFileName);

                await fs.promises.rename(photo.filepath, newPath);

                photoPath = `/uploads/${newFileName}`;
            }

            const hashedPassword = await bcrypt.hash(password, 10);

            await User.create({
                name: normalizedName,
                email: normalizedEmail,
                password: hashedPassword,
                photo: photoPath
            });

            req.session.message = 'Cadastro realizado com sucesso.';

            return res.redirect('/login');

        } catch (err) {
            console.error('Erro ao cadastrar usuário:', err);

            return res.status(500).render('errors', {
                title: 'Erro ao cadastrar usuário.',
                message: 'Não foi possível realizar seu cadastro, tente novamente.'
            });
        }
    });
}





async function loginUser(req, res) {
    const { email, password } = req.body;

    if (typeof email !== 'string' || typeof password !== 'string') {
        req.session.loginErrors = {
            general: 'Dados inválidos.'
        };

        req.session.loginValues = {
            email: ''
        };

        return res.redirect('/login');
    }

    const normalizedEmail = email.trim().toLowerCase();

    if (!normalizedEmail || !password) {
        req.session.loginErrors = {
            general: 'Preencha o e-mail e a senha.'
        };

        req.session.loginValues = {
            email: normalizedEmail
        };

        return res.redirect('/login');
    }

    const user = await User.findOne({
        where: { email: normalizedEmail }
    });

    if (!user) {
        req.session.loginErrors = {
            general: 'E-mail ou senha incorretos.'
        };

        req.session.loginValues = {
            email: normalizedEmail
        };

        return res.redirect('/login');
    }

    const passwordMatches = await bcrypt.compare(
        password,
        user.password
    );

    if (!passwordMatches) {
        req.session.loginErrors = {
            general: 'E-mail ou senha incorretos.'
        };

        req.session.loginValues = {
            email: normalizedEmail
        };

        return res.redirect('/login');
    }

    req.session.userId = user.id;
    req.session.userPhoto = user.photo;
    req.session.username = user.name;

    req.session.message = 'Login realizado com sucesso.';

    return res.redirect('/profile');
}

function logout(req, res) {
    if (!req.session) {
        return res.redirect('/login');
    }

    req.session.destroy((err) => {
        if (err) {
            return res.status(500).render('errors', {
                title: 'Não conseguimos encerrar sua sessão.',
                message: 'Ocorreu um problema ao sair da sua conta. Tente novamente.'
            });
        }

        return res.redirect('/login');
    });
}


export {
    showRegister,
    showLogin,
    registerUser,
    loginUser,
    logout,
}
