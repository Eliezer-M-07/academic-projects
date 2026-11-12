import app from './app.js';
import sequelize from './src/config/database.js';

const PORT = process.env.PORT || 3000;

try {
    await sequelize.authenticate();
    
    app.listen(PORT, () => {
        console.log(`Servidor rodando em http://localhost:${PORT}`);
    });
} catch (error) {
    console.error('Erro ao conectar ao banco:', error);
}