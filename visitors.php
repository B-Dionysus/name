<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> Visitors </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<STYLE type="text/css">
.ip
{
	border-top:3px solid gray;
	border-right:3px solid black;
	border-bottom:3px solid black;
	border-left:3px solid gray;
	padding:1px;
}
.date
{
}
.visits
{
}
.heading
{
	font-weight:bold;
	font-size:110%;
}
td
{
	padding:5px;
}
.whois
{
	position: absolute;
	top: 60px;
	left: 300px;
	width:80%;
	border:3px solid black;
	margin-top:40px;
	padding:10px;
	background-color:orange;
	color:black;
	font-family:sans-serif;
}
a
{
	color:black;
	text-decoration:none;
}
</style>
</HEAD>

<BODY>
<div>
<table border='1px' width="80%"><tr><td><span class='heading'>IP Address</span></td><td><span class='heading'>Most Recent Date</span></td><td><span class='heading'>Total Visits</span></td><td><span class='heading'>Referrer</span></td></tr>

<?PHP 
if(!$link)
{
	$link=mysql_connect("localhost","damien","fhben")
	 or die("Could not connect to database.");
	mysql_select_db("damiendb") or die("Database not found.");
}
$sql="select ip, visits, date, referrer from visitors where project='name.sixbynine.com' group by ip order by date desc";
$res=MYSQL_QUERY($sql);
while($data=MYSQL_FETCH_ASSOC($res))
{
	$vql="select visits from visitors where project='name.sixbynine.com' and ip='".$data['ip']."' order by date asc limit 1";
	$ves=MYSQL_QUERY($vql);
	$vata=MYSQL_FETCH_ASSOC($ves);
	print "<tr><td><span class='ip'><a href='?cmd=whois&ip=".$data['ip']."'>".$data['ip']."</a></span></td><td><span class='date'>".date("M. j, y G:i.s  T", $data['date'])."</span></td><td align='center'><span class='visits'>".$vata['visits']."</span></td><td align='center'><span class='visits'><a target='_blank' href='".$data['referrer']."'>".$data['referrer']."</a></span></td></tr>\n";
}
?>
</table>
</div>
<?PHP
if($cmd=$_REQUEST['cmd'])
{
	if($cmd=="whois")
	{
		print "<div class='whois'>";


$handle=popen("whois ".$_REQUEST['ip'],"r");
if($handle)
{
	while (!feof($handle)) 
	{
		$buffer = fgets($handle, 4096);
        print $buffer."<br />";
	}
	pclose($handle);
}
		print "</div>";
    }
}
?>

</body>
</html>
