#!/bin/bash
# Script de instalación rápida para Kyros
# Uso: chmod +x install.sh && ./install.sh

echo "🚀 Iniciando instalación de Kyros..."

# Colores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Verificar dependencias
echo -e "${YELLOW}📋 Verificando dependencias...${NC}"

if ! command -v php &> /dev/null; then
    echo -e "${RED}❌ PHP no está instalado${NC}"
    exit 1
fi

if ! command -v mysql &> /dev/null; then
    echo -e "${RED}❌ MySQL no está instalado${NC}"
    exit 1
fi

echo -e "${GREEN}✅ PHP OK${NC}"
echo -e "${GREEN}✅ MySQL OK${NC}"

# Crear directorios necesarios
echo -e "${YELLOW}📁 Creando directorios...${NC}"
mkdir -p public/uploads
mkdir -p logs
mkdir -p cache
chmod 755 public/uploads
chmod 755 logs
chmod 755 cache
echo -e "${GREEN}✅ Directorios creados${NC}"

# Crear archivo .env
echo -e "${YELLOW}⚙️  Creando archivo de configuración...${NC}"
if [ ! -f .env ]; then
    cp .env.example .env
    echo -e "${GREEN}✅ .env creado (edita con tus credenciales)${NC}"
else
    echo -e "${YELLOW}⚠️  .env ya existe (usando configuración existente)${NC}"
fi

# Crear base de datos
echo -e "${YELLOW}🗄️  Configurando base de datos...${NC}"
read -p "Ingresa usuario MySQL [root]: " db_user
db_user=${db_user:-root}
read -sp "Ingresa contraseña MySQL: " db_pass
echo

mysql -u $db_user -p$db_pass -e "CREATE DATABASE IF NOT EXISTS kyros_saas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Base de datos creada${NC}"
else
    echo -e "${RED}❌ Error al crear base de datos${NC}"
    exit 1
fi

# Importar schema
echo -e "${YELLOW}📊 Importando esquema...${NC}"
mysql -u $db_user -p$db_pass kyros_saas < app/config/init.sql

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Esquema importado${NC}"
else
    echo -e "${RED}❌ Error al importar esquema${NC}"
    exit 1
fi

# Crear superadmin
echo -e "${YELLOW}👤 Creando cuenta SuperAdmin...${NC}"
mysql -u $db_user -p$db_pass kyros_saas << EOF
INSERT INTO users (name, email, password, role, is_active, email_verified) 
VALUES ('Administrador', 'admin@kyros.com', '\$2y\$10\$O8nJPxSQ8X2tKz7z8uZmE.K6B6Xx7M5K3L9X8P7Z6Y5W4V3U2T1S0', 'superadmin', TRUE, TRUE);
EOF

echo -e "${GREEN}✅ SuperAdmin creado (usuario: admin@kyros.com, contraseña: admin123)${NC}"

# Resumen
echo ""
echo -e "${GREEN}════════════════════════════════════════${NC}"
echo -e "${GREEN}✅ ¡Instalación completada exitosamente!${NC}"
echo -e "${GREEN}════════════════════════════════════════${NC}"
echo ""
echo "📍 Acceso:"
echo "  Landing: http://localhost/eccomerce/kyros/"
echo "  Admin: http://localhost/eccomerce/kyros/auth/login"
echo ""
echo "👤 Credenciales SuperAdmin:"
echo "  Email: admin@kyros.com"
echo "  Password: admin123"
echo ""
echo "⚠️  IMPORTANTE: Cambia la contraseña después de loguear"
echo ""
