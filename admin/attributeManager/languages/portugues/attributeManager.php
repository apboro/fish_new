<?php
/*
  $Id: attributeManager.php,v 1.0 21/02/06 Sam West$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  
  Tradução para Português do Brasil de AJAX-AttributeManager-V2.7
  
  por Valmy Gomes (Atualizado em 28/01/2010)
  Conheça a LEGALLOJA, uma OsCommerce integrada com Mercado Livre, Toda Oferta, Twitter e SMS
  http://www.legalloja.com.br
  valmygomes@legalzona.com.br  */

//attributeManagerPrompts.inc.php

define('AM_AJAX_YES', 'Sim');
define('AM_AJAX_NO', 'Não');
define('AM_AJAX_UPDATE', 'Atualizar');
define('AM_AJAX_CANCEL', 'Cancelar');
define('AM_AJAX_OK', 'OK');

define('AM_AJAX_SORT', 'Ordenar:');
define('AM_AJAX_TRACK_STOCK', 'Seguir stock?');
define('AM_AJAX_TRACK_STOCK_IMGALT', 'Seguir o stock deste atributo?');

define('AM_AJAX_ENTER_NEW_OPTION_NAME', 'Insira o nome do novo atributo');
define('AM_AJAX_ENTER_NEW_OPTION_VALUE_NAME', 'Novo valor');
define('AM_AJAX_ENTER_NEW_OPTION_VALUE_NAME_TO_ADD_TO', 'Insira o novo nome do valor para adicionar a %s');

define('AM_AJAX_PROMPT_REMOVE_OPTION_AND_ALL_VALUES', 'Tem certeza que deseja apagar os atributos de %s e todos seus valores para este produto?');
define('AM_AJAX_PROMPT_REMOVE_OPTION', 'Tem certeza que deseja apagar %s deste produto?');
define('AM_AJAX_PROMPT_STOCK_COMBINATION', 'Tem certeza que deseja remover esta combinação de stock deste produto?');

define('AM_AJAX_PROMPT_LOAD_TEMPLATE', 'Tem certeza que deseja carregar o Template %s? <br />Esta operação irá sobrepor as opções atuais do produto e não pode ser anulada!');
define('AM_AJAX_NEW_TEMPLATE_NAME_HEADER', 'Insira o nome do novo template. Ou...');
define('AM_AJAX_NEW_NAME', 'Novo nome:');
define('AM_AJAX_CHOOSE_EXISTING_TEMPLATE_TO_OVERWRITE', ' ...<br /> ... escolha um que já existe para o actualizar');
define('AM_AJAX_CHOOSE_EXISTING_TEMPLATE_TITLE', 'Já existente:'); 
define('AM_AJAX_RENAME_TEMPLATE_ENTER_NEW_NAME', 'Insira o novo nome para o Template %s');
define('AM_AJAX_PROMPT_DELETE_TEMPLATE', 'Tem certeza que deseja apagar o Template %s?<br>Esta operação não pode ser desfeita!');

//attributeManager.php

define('AM_AJAX_ADDS_ATTRIBUTE_TO_OPTION', 'Adiciona o atributo selecionado na esquerda para a opção %s');
define('AM_AJAX_ADDS_NEW_VALUE_TO_OPTION', 'Adiciona um novo valor para a opção %s');
define('AM_AJAX_PRODUCT_REMOVES_OPTION_AND_ITS_VALUES', 'Remover a opção %1$s e o(s) %2$d valor(es) abaixo deste produto');
define('AM_AJAX_CHANGES', 'Modificar'); 
define('AM_AJAX_LOADS_SELECTED_TEMPLATE', 'Carregar o Template selecionado');
define('AM_AJAX_SAVES_ATTRIBUTES_AS_A_NEW_TEMPLATE', 'Gravar os atributos atuais como um novo Template');
define('AM_AJAX_RENAMES_THE_SELECTED_TEMPLATE', 'Alterar o nome do template selecionado');
define('AM_AJAX_DELETES_THE_SELECTED_TEMPLATE', 'Apagar o template selecionado');
define('AM_AJAX_NAME', 'Nome');
/*define('AM_AJAX_NAME', 'Nome do Atributo<a class="ajuda" href="#"><img src="layout/help1.gif" width="24" height="16" border="0"><span><font color="#FF0000">Atenção:</font><BR>
            Aqui você pode criar atributos para os Produtos e dar-lhes opções e valores diferentes. Os atributos servem para que você cadastre variedade de um mesmo produto. EX:<BR> "Opção" Tamanho = <font color="#FF0000">"Valores" P, M e G</font><BR>"Opção" Cor = <font color="#FF0000">"Valores" Azul, Preta, Rosa e Amarela</font><BR>"Opção" Voltagem = <font color="#FF0000">"Valores" 110v e 220v</font><BR>Os valores dos atributos também podem ter preços diferentes, para isto utilize o prefix + ou - e preencha o campo "Diferença de Preço".<BR>Use os "TEMPLATES" para salvar suas combinações de atributos e inserí-las rapidamente mais tarde. </span></a>
            ');*/
define('AM_AJAX_ACTION', 'Ação');
define('AM_AJAX_QT_PRO', 'Quantidades em stock');
define('AM_AJAX_PRODUCT_REMOVES_VALUE_FROM_OPTION', 'Remover %1$s de %2$s deste produto');
define('AM_AJAX_MOVES_OPTION_UP', 'Mover opção para cima');
define('AM_AJAX_MOVES_OPTION_DOWN', 'Mover opção para baixo');
define('AM_AJAX_MOVES_VALUE_UP', 'Mover valor para cima');
define('AM_AJAX_MOVES_VALUE_DOWN', 'Mover valor para baixo');
define('AM_AJAX_ADDS_NEW_OPTION', 'Adicionar uma nova opção na lista');
define('AM_AJAX_OPTION', 'Opção:');
define('AM_AJAX_VALUE', 'Valor:');
define('AM_AJAX_PREFIX', 'Prefixo:');
define('AM_AJAX_PRICE', 'Diferença de Preço:');
define('AM_AJAX_ATTRIBUTE_CODE', 'Code Suffix:');
define('AM_AJAX_WEIGHT_PREFIX', 'Prefixo de Peso:');
define('AM_AJAX_WEIGHT', 'Peso:');
define('AM_AJAX_SORT', 'Ordem:');
define('AM_AJAX_ADDS_NEW_OPTION_VALUE', 'Adicionar um novo valor na lista');
define('AM_AJAX_ADDS_ATTRIBUTE_TO_PRODUCT', 'Adicionar este atributo ao produto atual');
define('AM_AJAX_DELETES_ATTRIBUTE_FROM_PRODUCT', 'Apagar o atributo ou combinação de atributos do produto atual');
define('AM_AJAX_QUANTITY', 'Quantidade');
define('AM_AJAX_PRODUCT_REMOVE_ATTRIBUTE_COMBINATION_AND_STOCK', 'Apagar esta combinação de atributos e stock deste produto');
define('AM_AJAX_UPDATE_OR_INSERT_ATTRIBUTE_COMBINATIONBY_QUANTITY', 'Atualizar ou inserir a combinação de atributo com a determinada quantidade');
define('AM_AJAX_UPDATE_PRODUCT_QUANTITY', 'Definir a quantidade indicada para o produto atual');

//attributeManager.class.php
define('AM_AJAX_TEMPLATES', '-- Templates --');

//----------------------------
// Change: download attributes for AM
//
// author: mytool
//-----------------------------
define('AM_AJAX_FILENAME', 'Nome do Arquivo');
define('AM_AJAX_FILE_DAYS', 'Número de Dias');
define('AM_AJAX_FILE_COUNT', 'Máx. Downloads');
define('AM_AJAX_DOWLNOAD_EDIT', 'Alterar Opções de Download');
define('AM_AJAX_DOWLNOAD_ADD_NEW', 'Adicionar Opções de Download');
define('AM_AJAX_DOWLNOAD_DELETE', 'Apagar Opções de Download');
define('AM_AJAX_HEADER_DOWLNOAD_ADD_NEW', 'Adicionar Opções de Download a \"%s\"');
define('AM_AJAX_HEADER_DOWLNOAD_EDIT', 'Alterar Opções de Download de \"%s\"');
define('AM_AJAX_HEADER_DOWLNOAD_DELETE', 'Apagar Opções de Download \"%s\"');
define('AM_AJAX_FIRST_SAVE', 'Gravar produto antes de adicionar opções');

//----------------------------
// EOF Change: download attributes for AM
//-----------------------------

define('AM_AJAX_OPTION_NEW_PANEL','Nova Opção:');
define('AM_AJAX_SORT_NUMERIC', 'Ordem Numérica');
define('AM_AJAX_SORT_ALPHABETIC', 'Ordem Alfabética');

?>