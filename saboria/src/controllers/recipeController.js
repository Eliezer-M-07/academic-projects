import { Recipe, Category, User } from '../models/index.js';

import path from 'path';
import fs from 'fs';
import { IncomingForm } from 'formidable';

async function index(req, res) {
    try {
        const recipesPerPage = 6;

        const currentPage = Math.max(
            1,
            parseInt(req.query.page, 10) || 1
        );

        const { count, rows: recipes } = await Recipe.findAndCountAll({
            include: [
                { model: Category },
                { model: User }
            ],
            order: [['created_at', 'DESC']],
            limit: recipesPerPage,
            offset: (currentPage - 1) * recipesPerPage
        });

        const totalPages = Math.ceil(count / recipesPerPage);

        return res.render('recipes/index', {
            recipes,
            currentPage,
            totalPages
        });

    } catch (error) {
        return res.status(500).render('errors', {
            title: 'Erro ao carregar receitas.',
            message: 'Não foi possível carregar as receitas.'
        });
    }
}

async function showRecipe(req, res) {
    try {
        const recipe = await Recipe.findByPk(req.params.id, {
            include: [
                { model: Category },
                { model: User }
            ]
        });

        if (!recipe) {
            return res.redirect('/recipes');
        }

        return res.render('recipes/show', {
            recipe
        });

    } catch (error) {
        console.error('Erro ao carregar receita:', error);

        return res.status(500).render('errors', {
            title: 'Erro ao carregar receita.',
            message: 'Não foi possível carregar esta receita.'
        });
    }
}

async function showRegister(req, res) {
    try {
        const categories = await Category.findAll({
            order: [['name', 'ASC']]
        });

        const errors = req.session.recipeErrors || {};
        const values = req.session.recipeValues || {};

        delete req.session.recipeErrors;
        delete req.session.recipeValues;

        return res.render('recipes/register', {
            categories,
            errors,
            values
        });

    } catch (err) {
        return res.status(500).render('errors', {
            title: 'Erro ao carregar formulário.',
            message: 'Não foi possível carregar a página de cadastro de receitas.'
        });
    }
}

async function editRecipeForm(req, res) {
    try {
        const recipe = await Recipe.findOne({
            where: {
                id: req.params.id,
                user_id: req.session.userId
            }
        });

        if (!recipe) {
            return res.redirect('/profile');
        }

        const categories = await Category.findAll({
            order: [['name', 'ASC']]
        });

        const errors = req.session.recipeErrors || {};
        const values = req.session.recipeValues || {};

        delete req.session.recipeErrors;
        delete req.session.recipeValues;

        return res.render('recipes/edit', {
            recipe,
            categories,
            errors,
            values
        });

    } catch (error) {
        return res.status(500).render('errors', {
            title: 'Erro ao carregar formulário.',
            message: 'Não foi possível carregar a página de edição.'
        });
    }
}

async function editRecipe(req, res) {

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
            const title = fields.title?.[0];
            const description = fields.description?.[0];
            const categoryId = fields.category_id?.[0];

            const errors = {};

            if (typeof title !== 'string' || typeof description !== 'string' || typeof categoryId !== 'string') {
                req.session.recipeErrors = {
                    general: 'Dados inválidos.'
                };

                req.session.recipeValues = {};

                return res.redirect(`/recipes/edit/${req.params.id}`);
            }

            const normalizedTitle = title.trim();
            const normalizedDescription = description.trim();

            if (!normalizedTitle) {
                errors.title = 'O título é obrigatório.';
            } else if (normalizedTitle.length > 150) {
                errors.title = 'O título deve ter no máximo 150 caracteres.';
            }

            if (!normalizedDescription) {
                errors.description = 'A descrição é obrigatória.';
            }

            const category = await Category.findByPk(categoryId);

            if (!category) {
                errors.category_id = 'Selecione uma categoria válida.';
            }

            const archive = files.archive?.[0];

            if (archive && archive.size > 0 && !['image/jpeg', 'image/png', 'image/webp'].includes(archive.mimetype)) {
                errors.archive = 'Selecione uma imagem JPG, PNG ou WEBP.';
            }

            if (Object.keys(errors).length > 0) {
                req.session.recipeErrors = errors;

                req.session.recipeValues = {
                    title: normalizedTitle,
                    description: normalizedDescription,
                    category_id: categoryId
                };

                return res.redirect(`/recipes/edit/${req.params.id}`);
            }

            const recipe = await Recipe.findOne({
                where: {
                    id: req.params.id,
                    user_id: req.session.userId
                }
            });

            if (!recipe) {
                return res.redirect('/profile');
            }

            let archivePath = recipe.archive;

            if (archive && archive.size > 0) {
                const folder = path.join(process.cwd(), 'public', 'uploads');

                await fs.promises.mkdir(folder, { recursive: true });

                const ext = path.extname(archive.originalFilename);
                const newFileName = archive.newFilename + ext;
                const oldPath = archive.filepath;
                const newPath = path.join(folder, newFileName);

                await fs.promises.rename(oldPath, newPath);

                const oldArchivePath = path.join(
                    process.cwd(),
                    'public',
                    recipe.archive.replace(/^\/+/, '')
                );

                await fs.promises.unlink(oldArchivePath).catch(err => {
                    if (err.code !== 'ENOENT') {
                        console.error('Erro ao remover foto antiga:', err);
                    }
                });

                archivePath = `/uploads/${newFileName}`;
            }

            await recipe.update({
                title: normalizedTitle,
                description: normalizedDescription,
                category_id: categoryId,
                archive: archivePath
            });

            req.session.message = 'Receita atualizada com sucesso.';

            return res.redirect('/profile');

        } catch (err) {
            console.error('Erro ao editar receita:', err);

            return res.status(500).render('errors', {
                title: 'Erro ao editar receita.',
                message: 'Não foi possível editar sua receita, tente novamente.'
            });
        }
    });
}

async function createRecipe(req, res) {

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
            const title = fields.title?.[0];
            const description = fields.description?.[0];
            const categoryId = fields.category_id?.[0];

            const errors = {};

            if (typeof title !== 'string' || typeof description !== 'string' || typeof categoryId !== 'string') {
                req.session.recipeErrors = {
                    general: 'Dados inválidos.'
                };

                req.session.recipeValues = {};

                return res.redirect('/recipes/create');
            }

            const normalizedTitle = title.trim();
            const normalizedDescription = description.trim();

            if (!normalizedTitle) {
                errors.title = 'O título é obrigatório.';
            } else if (normalizedTitle.length > 150) {
                errors.title = 'O título deve ter no máximo 150 caracteres.';
            }

            if (!normalizedDescription) {
                errors.description = 'A descrição é obrigatória.';
            }

            const category = await Category.findByPk(categoryId);

            if (!category) {
                errors.category_id = 'Selecione uma categoria válida.';
            }

            const archive = files.archive?.[0];

            if (!archive || archive.size === 0) {
                errors.archive = 'A foto da receita é obrigatória.';

            } else if (!['image/jpeg', 'image/png', 'image/webp'].includes(archive.mimetype)) {
                errors.archive = 'Selecione uma imagem JPG, PNG ou WEBP.';
            }

            if (Object.keys(errors).length > 0) {
                req.session.recipeErrors = errors;

                req.session.recipeValues = {
                    title: normalizedTitle,
                    description: normalizedDescription,
                    category_id: categoryId
                };

                return res.redirect('/recipes/create');
            }

            const folder = path.join(process.cwd(), 'public', 'uploads');

            await fs.promises.mkdir(folder, { recursive: true });

            const ext = path.extname(archive.originalFilename);
            const newFileName = archive.newFilename + ext;
            const oldPath = archive.filepath;
            const newPath = path.join(folder, newFileName);

            await fs.promises.rename(oldPath, newPath);

            await Recipe.create({
                title: normalizedTitle,
                description: normalizedDescription,
                category_id: categoryId,
                archive: `/uploads/${newFileName}`,
                user_id: req.session.userId
            });

            req.session.message = 'Receita publicada com sucesso.';

            return res.redirect('/profile');

        } catch (err) {
            console.error('Erro ao cadastrar receita:', err);

            return res.status(500).render('errors', {
                title: 'Erro ao cadastrar receita.',
                message: 'Não foi possível cadastrar sua receita, tente novamente.'
            });
        }
    });
}

async function deleteRecipe(req, res) {
    try {
        const recipe = await Recipe.findOne({
            where: {
                id: req.params.id,
                user_id: req.session.userId
            }
        });

        if (!recipe) {
            return res.redirect('/profile');
        }

        const archivePath = path.join(
            process.cwd(),
            'public',
            recipe.archive.replace(/^\/+/, '')
        );

        await fs.promises.unlink(archivePath).catch(err => {
            if (err.code !== 'ENOENT') {
                console.error('Erro ao remover foto antiga:', err);
            }
        });

        await recipe.destroy();

        req.session.message = 'Receita excluída com sucesso.';

        return res.redirect('/profile');

    } catch (err) {
        return res.status(500).render('errors', {
            title: 'Erro ao excluir receita.',
            message: 'Não foi possível excluir sua receita, tente novamente.'
        });
    }
}

export {
    index,
    showRecipe,
    showRegister,
    createRecipe,
    editRecipeForm,
    editRecipe,
    deleteRecipe
}