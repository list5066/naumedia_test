
<?
foreach(array_diff(scandir("classes"), [".", ".."]) as $file)
require_once "classes/$file";

?><!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Тестовое задание</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=bf7a0c75-a568-4b1f-b7b9-2350a5bb6912&lang=ru_RU" type="text/javascript"></script>
    <link href="./style.css" rel="stylesheet">
    <script src="./script.js" type="text/javascript"></script>
  </head>
  <body class="py-4">
    
  <?
    $firstText = "Большая Очаковская, вааса 3
Измайловский проспект дом 47, кв 15, Эспоо 2
Красногорск, деревня Глухово, Симпл 1
Краснопролетарская, 9 - 41, Вааса 4 Симпл 1
Новослободская 23, Вааса 2 2шт, вааса3. 
проезд Шокальского 49 к1, кв. 281, Эспоо 3. Симпл 1
Рокоссовского, Вааса 2
Складочная,4,кв162(2 подъезд), Эспоо 32
ул. Римского-Корсакова, 11к4, кв 13,  Симпл 1 краска, 6шт.
ул.Сергея Эйзенштейна, 6, Симпл 2
Феодосийская 7к6, Симпл 1 частично 8шт,
Ярославское шоссе д8.1, Эспоо 4 краска";
    $textData = $_POST["textdata"] ?? (isset($_GET["test"]) ? $firstText : "");

    if (!empty($textData))
    {
      $textData = htmlspecialchars($textData, ENT_QUOTES);
      $ob = new Naumedia\Example\PointsParser($textData);
      $ob->parse(new Naumedia\Example\CurrentLineParser());
      $pointsData = $ob->getPointsData();
    }

    ?>
    <script>
      top.pointsData = <?=json_encode($pointsData)?>;
    </script>

    <main>
      <div class="container">

        <h1>Пример карты с формой</h1>
        <p class="lead">Тестовое задание</p>
        <p>Отображение точек на карте с доп. данными</p>

        <form action="" method="post">
          <div class="row mb-3 text-left">
            <div class="col-7 themed-grid-col">
              <div id="map"></div>
            </div>
            <div class="col-5 themed-grid-col">
              <textarea name="textdata" id="textdata" class="form-control" placeholder="Укажите список адресов и товаров"><?
              if (!empty($_POST["textdata"]))
              {
                echo htmlspecialchars($_POST["textdata"], ENT_QUOTES);
              }
              ?></textarea>
              <hr>
              <button class="w-100 btn btn-primary btn-lg" type="submit">Отправить данные</button>
              <hr>
              <b>Пример текста для данного поля</b>
              <pre style="text-align: left"><?=$firstText?></pre>
            </div>
          </div>
        </form>
      </div>
    </main>
  </body>
</html>
