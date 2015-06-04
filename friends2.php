<html>
<head>
<script>
function showUser(str) {
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","showfriends.php?q="+str,true);
  alert ("showfriends.php?q="+str);
  xmlhttp.send();
}
</script>
</head>
<body>
    <form>
        <option value="">Select a friend:</option>
        <option value="$r"></option>
        
    </form>
<?php
    showUser(this.value)="select * from Users on uname";
    $r=showUser(this.value);
    $c="select count(uname) from Users";
    for($i=1;$i<=$c;$i++)
    {
        echo $r;
    }
    
    ?>

<br>
<div id="txtHint"><b>Person info will be listed here.</b></div>

</body>
</html>
