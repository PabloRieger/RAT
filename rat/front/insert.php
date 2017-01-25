<?
/*Insert botão salvar*/
$con = mysql_connect("localhost", "glpi", "password") or
   3:    die('Não foi possível conectar');
   4:
   5:$solucao = $_POST['solution'];
   6:
   8:
   9:mysql_select_db("glpi", $con);
  10:mysql_query(" glpi_tickets(solution) VALUES ('$solucao')");
  11:mysql_close($con);
?>
