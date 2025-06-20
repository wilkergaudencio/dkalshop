# 🧱 Loja DkalShop com Breeze Evolution

Este projeto é uma loja virtual construída com **Magento (Mage-OS)** e o tema **[SwissUp Breeze Evolution](https://swissuplabs.com/magento2/extensions/breeze-evolution/)**, focado em performance, frontend moderno e compatibilidade mobile.

> Ideal para lojas pequenas e médias que precisam de uma base leve, rápida e pronta para customizações.

---

## 🚀 Tecnologias Utilizadas

* **Mage-OS** 1.2.0
* **MySQL 8.0**
* **PHP 8.2+**
* **Docker (via markshust/docker-magento)**
* **Redis, Elasticsearch, RabbitMQ**
* **Tema frontend**: `swissup/breeze-evolution`

---

## 🛠️ Instalação

### 1. Clone o projeto

```bash
git clone https://github.com/SEU_USUARIO/seu-projeto-magento.git
cd seu-projeto-magento
```

### 2. Gere a estrutura base com template Mark Shust

```bash
curl -s https://raw.githubusercontent.com/markshust/docker-magento/master/lib/template | bash
```

### 3. Configure o arquivo `.env`

```env
COMPOSE_PROJECT_NAME=magento
DOMAIN=magento.local
VERSION=1.2.0
MAGENTO_EDITION=mageos
MYSQL_VERSION=8.0
```

### 4. Inicie o ambiente

```bash
bin/start
bin/download mageos 1.2.0
bin/setup magento.local
```

---

## 🎨 Ativando o tema Breeze Evolution

### 1. Adicione o repositório da SwissUp

```bash
composer config repositories.swissup composer https://swissup.github.io/packages/
```

### 2. Instale o tema

```bash
composer require swissup/breeze-evolution
```

### 3. Compile e implante os arquivos

```bash
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy -f
```

### 4. Ative o tema no admin

Acesse:

```
Content > Design > Configuration > [store view] > Theme: Swissup/BreezeEvolution
```

### 5. Configure a página inicial

* Crie uma CMS Page com URL key `home`
* Acesse: `Stores > Configuration > Web > Default Pages`
* Defina a CMS Home Page como "Home"

---

## 🧩 Comandos úteis

```bash
bin/magento cache:flush
bin/magento indexer:reindex
bin/magento setup:upgrade
bin/magento setup:static-content:deploy -f
```

---

## 🧬 Dicas finais

* O tema **não vem com layout demo**. É necessário criar sua homepage manualmente.
* Para recursos visuais prontos, você pode instalar módulos extras da SwissUp, como EasySlide, CMS Tabs e Widgets.

---

## 🤝 Contribuições

1. Faça um fork
2. Crie uma branch com suas alterações
3. Envie um Pull Request

---

## 📄 Licença

Este projeto segue os termos de uso do Mage-OS, Magento Open Source e SwissUp Labs.

---

## 🙏 Agradecimentos

* [Mark Shust](https://github.com/markshust/docker-magento) – Docker Magento Base
* [SwissUp Labs](https://swissuplabs.com) – Tema Breeze Evolution
* [Mage-OS](https://mage-os.org) – Magento Open Source moderno

