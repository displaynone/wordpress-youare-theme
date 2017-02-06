<?php 
// Tool for getting dic words
exec('find . -name "*.php" -exec grep -H -n "__(" {} \; > salida.txt');
exec('find . -name "*.php" -exec grep -H -n "_e(" {} \; >> salida.txt');
$txt = file_get_contents('salida.txt');
$txt = explode("\n", $txt);
$palabras = array();
foreach($txt as $i=>$line) {
  preg_match_all('#_[_e]\([\'"](.+)[\'"],\s+[\'"]([^\'"]+)[\'"]\)#U', $line, $m);
//  preg_match_all('#_[_e]\([\'"]([^\'"]+\'[^\'"]+)[\'"],\s+[\'"]([^\'"]+)[\'"]\)#', $line, $m);
//  preg_match_all('#_[_e]\([\'"]([^\'"]+)[\'"],\s+[\'"]([^\'"]+)[\'"]\)#', $line, $m);
 
  if (false && isset($m[2][0]) && $m[2][0] != 'youare') {
    echo "ERROR ".$m[2].'----'.$line."\n";
    continue;
  }
  //var_dump($m);continue;  
  if (isset($m[1])) {
    foreach($m[1] as $v) {
      $f = explode(':', $line, 3);
      if (!isset($palabras[$v])) $palabras[$v] = array(array(), "");
      $palabras[$v][0][] = str_replace('./', '#: wp-content/themes/you/', $f[0]).':'.$f[1];
      $palabras[$v][1] = 'msgid "'.$v.'"'."\n".'msgstr ""'."\n\n";
    }
  }
}
foreach($palabras as $p) {
  echo implode("\n", $p[0])."\n";
  echo $p[1];
}
unlink('salida.txt');
