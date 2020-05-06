<?php
error_reporting(0);
echo "<html lang=\"en\">
<link href='index.css' rel='stylesheet'>
<head>
    <meta charset=\"UTF-8\">
    <title>3 лаба 4 вариант</title>
</head>
<body>";

if(isset($_GET['path'])) $path = $_GET['path']; //объявляем переменную и присваиваем переданное GET-запросом значение
else $path = "C:\Users\andre\PhpstormProjects\\"; //объявляем переменную и присваиваем стандартное значение
if($path[strlen($path)-1]!='\\') $path[strlen($path)]='\\'; //добавляем слеш в конец пути, если его нет
if(!(is_dir($path))) //если каталог не существует
{
        echo "<div align='center'>";
        echo "<form action=\"laba3_var4.php\" method=\"get\">
        <input type=\"text\" value=\"$path\" class='input_text error_red' name=\"path\">
        <input type=\"submit\" value=\"Отправить\" name=\"submit\">
    </form>";
        echo "<h2>Неверный каталог! Попробуйте еще раз</h2>";
        echo "</div>";
        echo "</body>";
        echo "</html>";
        return;
}
else //если каталог существует
{
        echo "<div align='center'>";
        echo "<form action=\"laba3_var4.php\" method=\"get\">
        <input type=\"text\" value=\"$path\" class='input_text' name=\"path\">
        <input type=\"submit\" value=\"Отправить\" name=\"submit\">
    </form>
    </div>";
}

echo "<div align='center'>";
echo "Введенный путь: $path<br><br>"; //вывод введенного значения
echo "<table>"; //открываем таблицу
Finder($path, 0);
echo "</table>"; //закрываем таблицу
echo "</div>";
echo "</body>";
echo "</html>";

function Finder(string $path, int $tab)
{
    ViewOne($path,"", $tab, 1);
    $path_dir_array = array();
        foreach (array_diff(scandir($path), array('.', '..')) as $name)
        {
            if(is_dir($path . $name)) array_push($path_dir_array,$path . $name);
            else
            {
                ViewOne($path, $name, $tab, 0);
            }
        }
        foreach ($path_dir_array as $array_dir_path)
        {
            Finder($array_dir_path . '\\', $tab+4);
        }

}
function ViewOne(string $path, string $name, int $tab, bool $folder_mode)
{
    if($folder_mode)
    {
        $size_b = 0;
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $file)
        {
            $size_b+=$file->getSize();// ->getSize();
        }
    }
    else $size_b=filesize($path . $name);
    if(!($size_b==0)) $size_kb=ceil($size_b/(pow(2,10)));

    echo "<tr><td>";
    if($folder_mode && $tab>0) $tab-=4;
    for($i=0;$i<$tab;$i++) echo "_";
    if($folder_mode) echo "Папка: " . basename($path);
    if($size_b==0) echo "$name   Размер: $size_b б"; //вставляем строку с директорией
    else echo "$name   Размер: $size_b б (" . $size_kb . " Кб)"; //вставляем строку с директорией
    if($folder_mode) echo "↴";
    echo "</td></tr>";
}
