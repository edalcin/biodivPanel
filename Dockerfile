# Usar a imagem oficial do PHP 8.3 com Apache
FROM php:8.3-apache

# Instalar dependências do sistema necessárias para a extensão MongoDB e outras ferramentas úteis
# Adicionadas bibliotecas de desenvolvimento para compilação da extensão MongoDB com mais opções
RUN apt-get update && apt-get install -y \
    wget \
    unzip \
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev \
    zlib1g-dev \
    libsasl2-dev \
    libsnappy-dev \
    libzstd-dev \
    libutf8proc-dev \
    && rm -rf /var/lib/apt/lists/*

# Instalar a extensão MongoDB via PECL
# Removido "yes |" para usar padrões ou responder interativamente se necessário (embora em Docker deva ser não interativo)
# As dependências acima devem satisfazer as opções de compilação mais comuns.
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos do projeto para o diretório web do Apache
# Os arquivos da aplicação ficarão em /var/www/html/mongo_summary
COPY mongo_summary/ ./mongo_summary/

# O Apache já está configurado para servir a partir de /var/www/html
# A porta 80 já é exposta pela imagem base php:8.3-apache

# Comando padrão (já fornecido pela imagem base, mas pode ser explicitado se necessário)
# CMD ["apache2-foreground"]
