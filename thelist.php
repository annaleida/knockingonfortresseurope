<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?
require_once("knockingonfortr.php");
@include_once("conversion.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Knocking on Fortress Europe</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="title" content="Knocking on Fortress Europe" />
    <meta name="description" content="Artistic and political project to alert attention to the consequences of Europes immigration politics" />
    <meta name="keywords" content="fortress europe european union immigration humanitarian politics" />
    <meta name="language" content="en" />
    <meta name="robots" content="All" />
    <meta name="abstract" content="This site describes a political project to alert attention to European Union immigration politics" />
    <meta name="MSSmartTagsPreventParsing" content="true" />
    <!--link id="theme" rel="stylesheet" type="text/css" href="style.css" title="theme" /-->
  </head>
  <body> 

        <?
        //Fix pagination
        $max = 100; //amount of articles per page. change to what to want
        $p = $_GET['p'];
        if(empty($p))
        {
        $p = 1;
        }
        $limits = ($p - 1) * $max; 
        //echo "limits: " .$limits;
        //echo "p: " .$p;
        // Connect
        mysql_connect("knockingonfortresseurope.com.mysql",$username,$password);
        @mysql_select_db($database) or die( "Unable to select database");
        
        //the total rows in the table
        $totalres = mysql_result(mysql_query("SELECT COUNT(RECORD_NR) AS tot FROM `CASUALTIES`"),0);  
        //echo "totalres: " .$totalres;
        //the total number of pages (calculated result)
        $totalpages = ceil($totalres / $max); 
        //echo "totalpages: " .$totalpages;
        $prevPage = ($p>1)?$p-1:$p;
        $nextPage = ($p<$totalpages)?$p+1:$p;
        ?>

        <?
        //Fix query
        //$query = "SELECT `RECORD_NR`, `FOUND_DEAD`, `NUMBER` FROM `CASUALTIES` WHERE FOUND_DEAD LIKE '2015-04%'";
        //$query = "SELECT `RECORD_NR`, `FOUND_DEAD`, `NUMBER` FROM `CASUALTIES`";
        $query = "SELECT `RECORD_NR`, `FOUND_DEAD_YEAR`, `FOUND_DEAD_MONTH`, `FOUND_DEAD_DAY`,`NUMBER`, `NAME`, `COUNTRY_OF_ORIGIN` , `CAUSE_OF_DEATH` , `SOURCE`, `COUNTRY_OF_DEATH` , `WEBLINK` FROM `CASUALTIES` LIMIT ".$limits."," .$max;
        //$query = "SELECT `RECORD_NR`, `FOUND_DEAD_YEAR`, `FOUND_DEAD_MONTH`, `FOUND_DEAD_DAY`,`NUMBER`, `NAME`, `COUNTRY_OF_ORIGIN` , `CAUSE_OF_DEATH` , `SOURCE`, `COUNTRY_OF_DEATH` , `WEBLINK` FROM `CASUALTIES`";
        
        // echo $query;
        $result = mysql_query($query) or die("Unable to fetch records");
        mysql_close();
        $num=mysql_numrows($result);
        ?>

    <!-- top wrapper -->  
    <div id="topWrapper"> 
      <div id="topBanner"></div> 
    </div>  
    <div id="topnav"> 
          <a href="index.html" shape="rect"><< -- Back to Knocking On Fortress Europe</a>
    </div>  
    <!-- end top wrapper -->  
    <div id="wrapper"> 
      <? echo "<h3>THE LIST: page ".$p."</h3>"; ?>
      <div id="bg"> 
        <div id="header">
          <?
            echo  "<a href='thelist.php?p=$prevPage'><< -- Prev</a> ";
            for($i = 1; $i <= $totalpages; $i++){ 
            //this is the pagination link
            echo "<a href='thelist.php?p=$i'>$i</a> |";
          } 
echo  "<a href='thelist.php?p=$nextPage'>Next -- >></a> ";
          ?>
        </div>  
        <div id="page"> 
          <!-- begin container -->  
          <div id="container"> 
                <div id="tablecontent"> 
                          <table border="1" cellspacing="2" cellpadding="2">
                            <tr>
                            <th><font face="Arial, Helvetica, sans-serif">Record number</font></th>
                            <th><font face="Arial, Helvetica, sans-serif">Date</font></th>
                            <th><font face="Arial, Helvetica, sans-serif">Number</font></th>
                            <th><font face="Arial, Helvetica, sans-serif">Name</font></th>
                            <th><font face="Arial, Helvetica, sans-serif">Cause of death</font></th>
                            <th><font face="Arial, Helvetica, sans-serif">Country of origin</font></th>
                            <th><font face="Arial, Helvetica, sans-serif">Source</font></th>
                            <th><font face="Arial, Helvetica, sans-serif">Country of death</font></th>
                            <th><font face="Arial, Helvetica, sans-serif">weblink</font></th>
                            </tr>
                          <?
                          //Display results
                          $i=0;
                          while ($i < $num)
                              {
                                $record_nr=mysql_result($result,$i,"record_nr");
                                $found_dead_date=combine_date(mysql_result($result,$i,"found_dead_year"),mysql_result($result,$i,"found_dead_month"),mysql_result($result,$i,"found_dead_day"));
                                $number=mysql_result($result,$i,"number");
                                $name = mysql_result($result,$i,"name");
                                $country_of_death = mysql_result($result,$i,"country_of_death");
                                $country_of_origin = mysql_result($result,$i,"country_of_origin");
                                $cause_of_death = mysql_result($result,$i,"cause_of_death");
                                $source = mysql_result($result,$i,"source");
                                $weblink = mysql_result($result,$i,"weblink");
                          ?>
                          <tr>
                          <td><font face="Arial, Helvetica, sans-serif"><? echo $record_nr; ?></font></td>
                          <td><font face="Arial, Helvetica, sans-serif"><? echo $found_dead_date; ?></font></td>
                          <td><font face="Arial, Helvetica, sans-serif"><? echo $number; ?></font></td>
                          <td><font face="Arial, Helvetica, sans-serif"><? echo $name; ?></font></td>
                          <td><font face="Arial, Helvetica, sans-serif"><? echo $cause_of_death; ?></font></td>
                          <td><font face="Arial, Helvetica, sans-serif"><? echo $country_of_origin; ?></font></td>
                          <td><font face="Arial, Helvetica, sans-serif"><? echo $source; ?></font></td>
                          <td><font face="Arial, Helvetica, sans-serif"><? echo $country_of_death; ?></font></td>
                          <td><font face="Arial, Helvetica, sans-serif"><? echo $weblink; ?></font></td>
                          </tr>
                          <?$i++;
}
?>
                          </table>
                </div>
                <!-- end tablecontent -->   
              <div class="clear" style="height:40px"></div> 
          </div>  
          <!-- end container --> 
        </div>  
        <div id="footerWrapper">
        </div> 
      </div> 
    </div>  
    <div id="bottomWrapper"> 
      <div id="footer"> 
        <p style="padding-top:20px"> 
           &copy; 2015 Knocking on Fortress Europe. The List - courtesy of 
           <a href="http://www.unitedagainstracism.org" shape="rect" target="blank">United Against Racism</a>
        </p> 
      </div> 
    </div> 
  </body>
</html>
