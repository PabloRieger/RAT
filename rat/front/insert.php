<?
/*Insert bot�o salvar*/
$con = mysql_connect("localhost", "glpi", "password") or
   3:    die('N�o foi poss�vel conectar');
   4:
   5:$solucao = $_POST['solution'];
   6:
   8:
   9:mysql_select_db("glpi", $con);
  10:mysql_query(" glpi_tickets(solution) VALUES ('$solucao')");
  11:mysql_close($con);
?>
