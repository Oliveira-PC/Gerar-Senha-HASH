# 🔐 Gerar Senha HASH (PHP)

Ferramenta simples e funcional em **PHP + HTML** para gerar senhas aleatórias em formato **hexadecimal** e convertê-las em **hashes seguras** usando `password_hash()`.

Permite também inserir manualmente uma string hexadecimal e gerar seu hash correspondente, sem necessidade de banco de dados ou dependências externas.

---

## 🚀 Funcionalidades

- ✅ Geração de senhas aleatórias em hexadecimal (`random_bytes` / fallback seguro)  
- 🔒 Criação de hashes com `password_hash()` (usando `PASSWORD_DEFAULT`)  
- ✏️ Conversão de uma hexadecimal informada em hash  
- 📋 Botão para copiar senhas e hashes para a área de transferência  
- 💡 Interface leve e responsiva, feita com HTML e CSS puro  

---

## 🖥️ Pré-requisitos

- PHP 7.4 ou superior  
- Servidor local (ex: XAMPP, Laragon, WAMP ou PHP embutido)  

---

## ⚙️ Como usar

1. Clone este repositório:
git clone https://github.com/Oliveira-PC/Gerar-Senha-HASH.git

2. Acesse a pasta:
cd Gerar-Senha-HASH

3. Inicie o servidor PHP local:
php -S localhost:8080

4. Abra no navegador:
http://localhost:8080/index.php

---

## 🧰 Estrutura do projeto

Gerar-Senha-HASH/
│
├── index.php # Arquivo principal (PHP + HTML + CSS + JS)
└── README.md # Este arquivo

---

## 📸 Exemplo de uso

- Gere uma senha aleatória em hexadecimal  
- Copie a senha e/ou seu hash gerado  
- Insira uma senha manualmente e converta para hash  

---

## ⚠️ Observação importante

As hashes geradas com `password_hash()` **não podem ser revertidas**.  
Essa ferramenta **não decifra** hashes, apenas as **gera de forma segura**.  

---

## 📄 Licença

Este projeto está sob a licença **MIT** — sinta-se livre para usar, modificar e compartilhar.  

---

### 💬 Criado por [OliveiraPC](https://github.com/Oliveira-PC)
