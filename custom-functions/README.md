# Funcionalidades Personalizadas - Storebiz Theme

Este diretório contém todas as funcionalidades personalizadas do tema Storebiz, organizadas em arquivos separados para melhor manutenção e organização.

## Estrutura de Arquivos

### 📁 `custom-functions/`
Diretório principal que contém todas as funcionalidades personalizadas.

### 📄 `loader.php`
Arquivo principal que carrega todos os outros arquivos de funcionalidades. Este arquivo é incluído no `functions.php` principal do tema.

### 📄 `custom-styles.php`
**Estilos CSS Personalizados Globais**
- Carregamento de estilos CSS personalizados para todas as lojas do multisite
- Sistema de fallback com estilos inline caso o arquivo CSS não exista
- Estilos para categorias de loja, checkout WooCommerce, produtos, etc.
- Compatível com WordPress Multisite e WooCommerce

### 📄 `woocommerce-upload.php`
**Funcionalidades de Upload de Arquivos no WooCommerce**
- Campo de upload de arquivo no checkout
- Validação de upload obrigatório para pagamentos com cheque
- Script jQuery para upload via AJAX
- Manipulação de upload via AJAX
- Salvamento da URL do arquivo nos metadados do pedido
- Exibição do arquivo enviado na página de administração do pedido

### 📄 `woocommerce-checkout.php`
**Funcionalidades de Checkout Personalizadas**
- Campo Bairro obrigatório
- Personalização do campo empresa
- Controle de endereço de entrega para pessoa jurídica
- Scripts para controlar checkbox e tipo de pessoa
- Limitação de quantidade de estoque
- Personalização de thumbnail do carrinho
- Ordenação de produtos por preço (maior para menor)
- Alteração do texto do botão "Adicionar ao Carrinho"

### 📄 `registration-fields.php`
**Campos de Registro Personalizados**
- Campos extras no formulário de registro
- Validação dos campos extras
- Salvamento dos campos extras no registro
- Personalização da página de detalhes da conta
- Tradução de mensagens de login

### 📄 `banner-slider.php`
**Sistema de Banner/Slider**
- Configurações de banner no customizer
- Função para exibir o slider com links
- Carregamento de assets do Swiper
- Carregamento de estilos CSS personalizados

### 📄 `modal-quantidade.php`
**Modal de Quantidade**
- Modal que aparece quando o usuário excede o limite de quantidade
- Configurações do modal no customizer
- Estilos CSS e JavaScript para o modal
- Funcionalidade de copiar e-mail

### 📄 `admin-customizations.php`
**Personalizações do Painel Administrativo**
- Coluna de imagem personalizada para produtos
- Configurações de categorias no customizer
- Breadcrumb personalizado

## Como Usar

1. **Adicionar novas funcionalidades**: Crie um novo arquivo PHP no diretório `custom-functions/`
2. **Incluir no loader**: Adicione o nome do arquivo no array `$custom_files` no arquivo `loader.php`
3. **Manter organização**: Cada arquivo deve ter um propósito específico e bem definido

## Benefícios da Nova Estrutura

✅ **Organização**: Cada funcionalidade tem seu próprio arquivo
✅ **Manutenção**: Mais fácil de encontrar e modificar funcionalidades específicas
✅ **Legibilidade**: Código mais limpo e organizado
✅ **Escalabilidade**: Fácil adicionar novas funcionalidades
✅ **Debugging**: Mais fácil identificar problemas em funcionalidades específicas

## Exemplo de Adição de Nova Funcionalidade

```php
// 1. Criar arquivo: custom-functions/nova-funcionalidade.php
<?php
/**
 * Nova Funcionalidade
 * 
 * Descrição da funcionalidade
 */

// Suas funções aqui...

// 2. Adicionar no loader.php
$custom_files = array(
    // ... outros arquivos
    'nova-funcionalidade.php',    // Nova funcionalidade
);
```

## Notas Importantes

- Todos os arquivos devem ter verificação de segurança (`!defined('ABSPATH')`)
- Use comentários descritivos para documentar as funcionalidades
- Mantenha a consistência na nomenclatura dos arquivos
- Teste sempre após adicionar ou modificar funcionalidades 