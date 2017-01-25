<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/styles.termo.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/css.css" rel="stylesheet" type="text/css">

<link href="css/normalize.css" rel="stylesheet" type="text/css">
<!--<link href="css/rat.css" rel="stylesheet" type="text/css">;-->

<script src="js/js.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/javascript.js"></script>
</head>
<?php 
include ('../../../inc/includes.php');
include ('../../../config/config.php');
global $DB;
Session::checkLoginUser();
Html::header('RAT', "", "plugins", "rat");
echo Html::css($CFG_GLPI["root_doc"]."/css/styles.css");
if (isset($_SESSION["glpipalette"])) {
	echo Html::css($CFG_GLPI["root_doc"]."/css/palettes/".$_SESSION["glpipalette"].".css");
}
$SelPlugin = "SELECT * FROM glpi_plugin_rat_config";
$ResPlugin = $DB->query($SelPlugin);
$Plugin = $DB->fetch_assoc($ResPlugin);
$EmpresaPlugin = $Plugin['name'];
$EnderecoPlugin = $Plugin['address'];
$TelefonePlugin = $Plugin['phone'];
$CidadePlugin = $Plugin['city'];
$CorPlugin = $Plugin['color'];
$CorTextoPlugin = $Plugin['textcolor'];

$SelTicket = "SELECT * FROM glpi_tickets WHERE id = '".$_GET['id']."'";
$ResTicket = $DB->query($SelTicket);
$Ticket = $DB->fetch_assoc($ResTicket);
$OsId = $_GET['id'];

$OsNome = $Ticket['name'];
$SelDataInicial = "SELECT date,date_format(date, '%d/%m/%Y %H:%i') AS DataInicio FROM glpi_tickets WHERE id = '".$_GET['id']."'";
$ResDataInicial = $DB->query($SelDataInicial);
$DataInicial = $DB->fetch_assoc($ResDataInicial);
$OsData = $DataInicial['DataInicio'];

$OsDescricao = $Ticket['content'];
$SelDataFinal = "SELECT due_date,date_format(due_date, '%d/%m/%Y %H:%i') AS DataFim FROM glpi_tickets WHERE id = '".$_GET['id']."'";
$ResDataFinal = $DB->query($SelDataFinal);
$DataFinal = $DB->fetch_assoc($ResDataFinal);
$OsDataEntrega = $DataFinal['DataFim'];

$OsSolucao = $Ticket['solution'];
$SelTicketUsers = "SELECT * FROM glpi_tickets_users WHERE tickets_id = '".$OsId."'";
$ResTicketUsers = $DB->query($SelTicketUsers);
$TicketUsers = $DB->fetch_assoc($ResTicketUsers);
$OsUserId = $TicketUsers['users_id'];

$SelIdOsResponsavel = "SELECT users_id FROM glpi_tickets_users WHERE tickets_id = '".$OsId."' AND type = 2";
$ResIdOsResponsavel = $DB->query($SelIdOsResponsavel);
$IdOsResponsavel = $DB->fetch_assoc($ResIdOsResponsavel);

$SelOsResponsavelName = "SELECT * FROM glpi_users WHERE id = '".$IdOsResponsavel['users_id']."'";
$ResOsResponsavelName = $DB->query($SelOsResponsavelName);
$OsResponsavelFull = $DB->fetch_assoc($ResOsResponsavelName);
$OsResponsavel = $OsResponsavelFull['firstname']. " " .$OsResponsavelFull['realname'];

$LocalizacaoId = $Ticket['locations_id'];
$SelLocalizacao = "SELECT * FROM glpi_locations where id = '".$LocalizacaoId."'";
$ResLocalizacao = $DB->query($SelLocalizacao);
$Localizacao = $DB->fetch_assoc($ResLocalizacao);
$LocalizacaoLocal = $Localizacao['completename'];

$SelItem = "select * from glpi_computers a, glpi_items_tickets b where b.tickets_id='".$OsId."' and (b.items_id = a.id)";
$ResItem = $DB->query($SelItem);
$Item = $DB->fetch_assoc($ResItem);
$ItemAdd = $Item['name'];
$ItemTipo = $Item['itemtype'];
$ItemPatrimonio = $Item['otherserial'];

/*$SelFabricante = "SELECT *
FROM glpi_computers a, glpi_items_tickets b, glpi_manufacturers c
WHERE b.tickets_id ='".$OsId."'
AND b.items_id = a.id
AND a.manufacturers_id = c.id";
$ResFabricante = $DB->query($SelFabricante);
$Fabricante = $DB->fetch_assoc($ResFabricante);
$FabricanteAdd = $Fabricante('c.name');*/

$SelItemMonitor = "select * from glpi_monitors a, glpi_items_tickets b where b.tickets_id='".$OsId."' and (b.items_id = a.id)";
$ResItemMonitor = $DB->query($SelItemMonitor);
$ItemMonitor = $DB->fetch_assoc($ResItemMonitor);
$ItemAddMonitor = $Item['name'];
$ItemTipoMonitor = $Item['itemtype'];

$EntidadeId = $Ticket['entities_id'];
$SelEmpresa = "SELECT * FROM glpi_entities a, glpi_tickets b WHERE a.id = '".$EntidadeId."' and b.id = '".$OsId."'";
$ResEmpresa = $DB->query($SelEmpresa);
$Empresa = $DB->fetch_assoc($ResEmpresa);
$EntidadeName = $Empresa['completename'];
$EntidadeCep = $Empresa['postcode'];
$EntidadeEndereco = $Empresa['address'];
$EntidadeEmail = $Empresa['email'];
$EntidadePhone = $Empresa['phonenumber'];
$EntidadeCnpj = $Empresa['comment'];

$SelEmail = "SELECT * FROM glpi_useremails WHERE users_id = '".$OsUserId."'";
$ResEmail = $DB->query($SelEmail);
$Email = $DB->fetch_assoc($ResEmail);
$UserEmail = $Email['email'];

?>
<body>
<!-- inicio dos botoes -->
<div id="botoes" style="width:55%; background:#fff; margin:auto; padding-bottom:10px;"> 
	<!--<input type="button" class="botao" name="configurar" value="Configurar" onclick="window.location.href='./index.php'"> -->
	<p></p>
	<form action="rat.php" method="get">	
	<input type="text" name="id" value="Digite a ID" onfocus="if (this.value=='Digite a ID') this.value='';" onblur="if (this.value=='') this.value='Digite a ID'" />
	<input class="submit" type="submit" value="Enviar">
	</form>
	<p></p>
	<a href="#" class="vsubmit" onclick="window.print();"> Imprimir </a>
	<!--<a href='os_cli.php?id=<?php echo $OsId; ?>' class="vsubmit"> Cliente </a>-->
	<a href='rat.php?id=<?php echo $OsId; ?>' class="vsubmit"> Empresa </a>
	<a href="index.php" class="vsubmit" style="float:right;"> Configurar </a>
	<p></p>
</div>
<!-- inicio das tabelas -->
<table style="width:190mm; background:#fff; margin:auto;" border="1" cellpadding="0" cellspacing="0"> 
<tr>
<td style="padding: 0px !important;" >
<table style="width:100%; background:#fff;" border="1">
<tr>
<td width="300" colspan="2">
<table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
<!-- tabela do logotipo -->
<tr><td height="90" valign="middle" style="width:25%; text-align:center; margin:auto;"><img src="./img/logo_os.PNG" width="120" height="90" align="absmiddle"></td>
<!-- tabela do titulo -->
<td style="text-align:center;"><p><font size="2">GOVERNO DO ESTADO DE MATO GROSSO DO SUL <br /> SECRETARIA DO ESTADO DE FAZENDA <br /> SUPERINTENDÊNCIA DE GESTÃO DA INFORMAÇÃO - SGI <br /> DETRAN/MS - Departamento Estadual de Trânsito de MS<?php echo($EmpresaPlugin);?></font></p>
<!--<p><font size="2"><?php echo ("$EnderecoPlugin - $CidadePlugin - $TelefonePlugin"); ?></font></p>-->
<!-- tabela do titulo segunda linha -->
<!--<p width="131" height="70"><font size="2"> Relatório de Atendimento Técnico Nº &nbsp;<b><?php echo $OsId;?> </font></b></p></tr> -->
<!-- fecha a tabela de titulo -->
</table></td>

<tr><td colspan="2"><center><b><font color="<?php echo $CorTextoPlugin; ?>"><br />Relatório de Atendimento Técnico Nº<b> &nbsp;<b><?php echo $OsId;?> </font></b></center><br /></td> </tr>
<!-- segunda tabela -->
<tr><td colspan="2" style="background-color:<?php echo $CorPlugin; ?> !important";><center><b><font color="<?php echo $CorTextoPlugin; ?>">DADOS DO CLIENTE</font></b></center></td> </tr>
<tr><td colspan="2" ><b>Empresa: </b><?php echo ($EntidadeName) ?></td>
<tr><td width="50%"><b>Endereço: </b><?php echo ($EntidadeEndereco)?></td><td><b>Telefone: </b><?php echo ($EntidadePhone)?></td></tr>

<!--Tabela do item-->
<tr><td Colspan="2" style="background-color:<?php echo $CorPlugin; ?> !important";><center><b><font color="<?php echo $CorTextoPlugin; ?>">DETALHES DO ITEM</font></b></center></td> </tr>
<tr><td width="50%" style="border:#cecece"><b>Item: </b><?php echo ($ItemAdd)?> <td width="50%" style="border:#cecece"><b> Tipo: </b><?php echo ($ItemTipo)?></td></tr>
<tr><td width="50%" style="border:#cecece"><b> Patrimônio: </b><?php echo ($ItemPatrimonio)?></td> </tr>
<tr><td width="50%" style="border:#cecece"><b>Marca:</b><?php echo ($FabricanteAdd)?> <td width="50%" style="border:#cecece"<b style="padding-left:194px"><b>Modelo: </b></br></tr>
<tr><td colspan="2" style="border:#cecece"><b>Localização: </b><?php echo ($LocalizacaoLocal)?></td></tr>

<!-- tabela OS -->
<tr><td colspan="2" style="background-color:<?php echo $CorPlugin; ?> !important";><center><b><font color="<?php echo $CorTextoPlugin; ?>">DETALHES DA RAT</font></b></center></td></tr>
<tr><td width="50%"><b>Título:</b> <?php echo $OsNome;?></td><td width="50%"><b>Responsável:</b> <?php echo $OsResponsavel;?></td></tr>
<tr><td width="50%"><b>Data/Hora de Início: </b><?php echo ($OsData);?></td><td><b>Data/Hora de Término: </b><?php echo ($OsDataEntrega);?></td></tr>
<tr><td colspan="2" style="background-color:<?php echo $CorPlugin; ?> !important";><center><b><font color="<?php echo $CorTextoPlugin; ?>">DESCRIÇÃO</font></b></center></td></tr>
<tr><td height="50" colspan="2" valign="top" style="padding:8px;"><?php echo nl2br($OsDescricao);?></td></tr>
<tr><td colspan="2" style="background-color:<?php echo $CorPlugin; ?> !important";><center><b><font color="<?php echo $CorTextoPlugin; ?>">SOLUÇÃO</font></b></center></td></tr>
<!-- Area de atendimento do tecnico-->
<tr> <form action="insert.php" method="post"> <td colspan="2"></td> <fieldset> <b>Detalhe do Atendimento:</b> <br><textarea rows="03" cols="110">  </textarea></fieldset>
<input type="submit" />
			</tr>
<!--Area do Ativo-->
<table style="width:100%; background:#fff; margin:auto;" border="1" cellpadding="0" cellspacing="0">
<tr><td colspan="3" style="background-color:<?php echo $CorPlugin; ?> !important";><center><b><font color="<?php echo $CorTextoPlugin; ?>">MOVIMENTAÇÃO DE EQUIPAMENTO</font></b></center></tr></td>
<tr><td width="33%"><b>Material Utilizado:</b> <?php echo $OsNome;?></td><td width="33%"><b>Patrimônio:</b> <?php echo $OsResponsavel;?></td><td width="33%"><b>Código Equipamento:</b> <?php echo $OsResponsavel;?></td>
			<table>
			<button id="add_material">Add Material</button>
			<button id="add_material_manual">Add Material Manualmente</button><br/></tr>
			</table>
<table style="width:100%; background:#fff; margin:auto;" border="1" cellpadding="0" cellspacing="0">
<tr>  <td width="33%"><b>Material Retirado:</b> <?php echo $OsNome;?></td><td width="33%"><b>Cod. Equipamento:</b> <?php echo $OsResponsavel;?></td><td width="33%"><b>Problema Apresentado:</b> <?php echo $OsResponsavel;?></td>

<table>

<button  action="pessoas.php" method="post" id="add_material">Add Material</button>
<button id="add_material_manual">Add Material Manualmente</button><br/></tr>	
</table>	
</table>			
</table>

<tr><td colspan="2" style="background-color:<?php echo $CorPlugin; ?> !important";><center><b><font color="<?php echo $CorTextoPlugin; ?>">ASSINATURAS</font></b></center></td></tr>
</table>
<br />
<br />
<table width="688" border="0" align="center" border="1" cellpadding="0" cellspacing="0">
<tr align="center"><td style="text-align:center;">____________________________________</td><td style="text-align:center;">_____________________________________</td></tr>
<tr align="center"><td style="text-align:center;"><b><?php echo $OsResponsavel;?></b></td><td style="text-align:center;" ><?php echo ($EmpresaPlugin);?></td></tr>
<tr align="center"><td style="text-align:center;">Diretoria de Téc da Informação</td><td style="text-align:center;" ><?php echo ($EmpresaPlugin);?></td></tr>
</table>
</table> 
</table>
<!-- estilo do botao para nao aparecer em impressao --> 
<style media="print">
</style>
</body>
</html>