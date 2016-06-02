<?php
require_once 'functions.php';
require_once 'simple_html_dom.php';
session_start();
$functs = new funcs();
$number = $_GET['number'];
?>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/allpages.css" rel="stylesheet">
    <style>
        h2.numbersol div {
            margin: 10px;
            text-align: center;
        }
        tr.textsol td p {
            margin: 10px 50px 10px 50px;
        }
    </style>
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0">
    <tr style="background-color: rgb(75,74,69);">
        <td height="40">
            <div style="color:white; text-align: center; font-size: 1.5em; font-weight: 100;">Контроль результатов обучения олимпиадному программированию</div>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid rgb(75,74,69);">
                <tr>
                    <th width="33%"><div>Примеры решений задач на строки acm.timus.ru</div><hr width="90%" align="left"></th>
                    <th width="33%"><div>Навигация</div><hr width="90%" align="left"></th>
                    <th width="33%"><div>Профиль</div><hr width="90%" align="left"></th>
                </tr>
                <tr class="navigation" valign="top">
                    <td>
                        <div>
                            Поиск наиболее встечающейся подстроки:
                            <a href="examplesolution.php?number=1723">1723</a><br>
                            Палиндромы:
                            <a href="examplesolution.php?number=1297">1297</a>
                            <a href="examplesolution.php?number=1354">1354</a><br>
                            Определение соответствия строки шаблону:
                            <a href="examplesolution.php?number=1102">1102</a>
                            <a href="examplesolution.php?number=1684">1684</a><br>
                            Циклический сдвиг строки:
                            <a href="examplesolution.php?number=1423">1423</a><br>
                            Количество различных подстрок строки:
                            <a href="examplesolution.php?number=1590">1590</a><br>
                        </div>
                    </td>
                    <td>
                        <div>
                            <a href="index.php">Главная</a><br>
                            <a href="solvedtasks.php">Решенные задачи</a><br>
							<a href="taskrating.php">Рейтинг по задаче</a><br>
                        </div>
                    </td>
                    <td>
                        <div>
                            <?php if (isset($_SESSION['user_id'])) : ?>
                                Вы вошли как: <a href="participants.php"><?php echo $functs->get_user_name($_SESSION['user_id']); ?></a><br>
                                <a href="participants.php">Участники ACM</a><br>
                                <a href='logout.php'>Выйти</a><br>
                            <?php else : ?>
                                Вы не вошли в систему<br>
                                <a href='authorization.php'>Авторизация</a><br>
                            <?php endif; ?>
                            <a href="registration.php">Регистрация</a><br>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
            <?php if ($number==1723) : ?>
                <tr>
                    <td>
                        <h2 class="numbersol"><div><a href="http://acm.timus.ru/problem.aspx?space=1&num=1723&locale=ru">1723. Книга Сандро</a></div></h2>
                    </td>
                </tr>
                <tr class="textsol">
                    <td>
                        <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Краткое условие:</strong></p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Программа должна считать единственную непустую строку из строчных латинских букв длиной не более 50. Вывести последовательность букв, которая повторяется наибольшее количество раз в строке. Если их несколько, то вывести любую из них.</p>
                        <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Идея решения: </strong></p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Отдельную букву, взятую из строки, будем считать последовательностью из одной буквы (то есть в ответ может быть выведена единственная буква, а не только последовательность из двух и более букв).</p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Если какая-то последовательность повторяется в строке наибольшее количество раз, и оно, допустим, равно k, то любая из букв этой последовательности повторяется тоже k раз, и поскольку, по условию, нужно вывести любую из последовательностей, то легче вывести и искать отдельную букву, которая повторяется в строке наибольшее количество раз.</p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; То есть решение состоит из подсчета количеств вхождений каждой буквы в строку, нахождения максимального из них и вывода соответствующей буквы.</p>
                        <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Код программы с комментариями:</strong></p>
						<?php
						$counttr=0;
						if (isset($_SESSION['user_id'])) {
							$timusid = $functs->get_timus_id($_SESSION['user_id']);
							$str = "http://acm.timus.ru/status.aspx?space=1&num=1723&author=" . $timusid . "&locale=ru";
							$htmltask = file_get_html($str);
							$exis = $htmltask->find('tr.even');
							$counttr = count($exis);
						}
						if ($counttr>0):
					    ?>
                        <pre class="cpp" style="font-family:monospace;">	<span style="color: #339900;">#include &lt;stdio.h&gt;</span>
&nbsp;
	<span style="color: #0000ff;">int</span> main <span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
		<span style="color: #0000ff;">int</span> mas <span style="color: #008000;">&#91;</span><span style="color: #0000dd;">26</span><span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span> <span style="color: #666666;">// массив для количества каждой из 26 строчных латинских 	</span>
		              <span style="color: #666666;">// букв. Элемент mas[0] равен количеству букв ‘a’ в строке, </span>
		      	      <span style="color: #666666;">// элемент mas[25] равен количеству букв ‘z’ в строке.</span>
		              <span style="color: #666666;">// Таким образом, индекс 0 соответствует букве ‘a’, индекс 	</span>
		              <span style="color: #666666;">// 1 букве ‘b’, 2 – ‘c’, 3 – ‘d’ … 25 – ‘z’.</span>
		              <span style="color: #666666;">// Поскольку букве ‘a’ соответствует аски-код 97, букве ‘b’ 	</span>
	      		      <span style="color: #666666;">// - 98, и т. д., то разность между аски-кодом буквы и 		</span>
		              <span style="color: #666666;">// индексом в массиве равна 97 для каждой буквы.</span>
		<span style="color: #0000ff;">char</span> stroka <span style="color: #008000;">&#91;</span><span style="color: #0000dd;">51</span><span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">char</span> symb<span style="color: #008080;">;</span>
		<span style="color: #0000ff;">int</span> i, kol, i_letter, temp, max, i_max<span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #0000dd;">scanf</span> <span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%s&quot;</span>, stroka<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #666666;">// находим количество букв в считанной строке, сохраняем в переменной kol: </span>
		<span style="color: #0000ff;">for</span><span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span><span style="color: #0000dd;">51</span><span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008000;">&#41;</span><span style="color: #008000;">&#123;</span>
				kol<span style="color: #000080;">=</span>i<span style="color: #008080;">;</span>
				<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
		<span style="color: #008000;">&#125;</span>
&nbsp;
		<span style="color: #666666;">// вначале количество каждой буквы равно 0.</span>
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span><span style="color: #0000dd;">26</span><span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			mas<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span> <span style="color: #000080;">=</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
		<span style="color: #008000;">&#125;</span>
&nbsp;
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span>kol<span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			temp <span style="color: #000080;">=</span> <span style="color: #008000;">&#40;</span> <span style="color: #0000ff;">unsigned</span> <span style="color: #0000ff;">int</span><span style="color: #008000;">&#41;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span> <span style="color: #666666;">// помещаем в переменную temp</span>
			                                  <span style="color: #666666;">// аски-код буквы stroka[i] </span>
			i_letter <span style="color: #000080;">=</span> temp <span style="color: #000040;">-</span> <span style="color: #0000dd;">97</span><span style="color: #008080;">;</span> 	<span style="color: #666666;">// расчитываем индекс массива mas, </span>
					        <span style="color: #666666;">// соответствующий этой букве</span>
			mas<span style="color: #008000;">&#91;</span>i_letter<span style="color: #008000;">&#93;</span><span style="color: #000040;">++</span><span style="color: #008080;">;</span>  <span style="color: #666666;">// увеличиваем количество этой буквы на один</span>
&nbsp;
		<span style="color: #008000;">&#125;</span>
&nbsp;
		<span style="color: #666666;">// находим максимальный элемент массива mas и его индекс (max и i_max):</span>
		<span style="color: #666666;">// (i_max будет равно индексу буквы, которая встречается в строке 	</span>
		<span style="color: #666666;">// наибольшее количество раз, если к этому индексу прибавить 97, то</span>
		<span style="color: #666666;">// получим аски-код этой буквы, если приведем его к типу char, то 	</span>
		<span style="color: #666666;">// получим ответ)</span>
&nbsp;
		max <span style="color: #000080;">=</span> mas<span style="color: #008000;">&#91;</span><span style="color: #0000dd;">0</span><span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>
		i_max<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span><span style="color: #0000dd;">26</span><span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			<span style="color: #0000ff;">if</span><span style="color: #008000;">&#40;</span>mas<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">&gt;</span>max<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
				max <span style="color: #000080;">=</span> mas<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>
				i_max<span style="color: #000080;">=</span>i<span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
		<span style="color: #008000;">&#125;</span>
&nbsp;
		symb<span style="color: #000080;">=</span><span style="color: #008000;">&#40;</span><span style="color: #0000ff;">char</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#40;</span>i_max<span style="color: #000040;">+</span><span style="color: #0000dd;">97</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #0000dd;">printf</span> <span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%c<span style="color: #000099; font-weight: bold;">\n</span>&quot;</span>, symb<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">return</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
	<span style="color: #008000;">&#125;</span></pre>
					<?php else :
						echo "<p style='color: red;'>Вы не можете просмотреть код программы, пока не было попыток решения этой задачи на сайте acm.timus.ru.</p>";
						endif;
					?>
                    </td>
                </tr>
                <?php elseif ($number==1297) : ?>
                    <tr>
                        <td>
                            <h2 class="numbersol"><div><a href="http://acm.timus.ru/problem.aspx?space=1&num=1297&locale=ru">1297. Палиндромы</a></div></h2>
                        </td>
                    </tr>
                    <tr class="textsol">
                        <td>
                            <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Краткое условие:</strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Программа должна считать единственную строку из латинских букв длиной не более 1000. Вывести максимальную по длине подстроку, читающуюся одинаково в обоих направлениях (палиндром). Если максимальных по длине подстрок больше одной, вывести самую левую из них.</p>
                            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Идея решения: </strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Рассмотрим два случая:</p>
                            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1) Будем искать максимальный по длине палиндром, который состоит из нечетного количества букв. Каждую позицию в строке будем считать центром палиндрома. Дальше сравниваем две соседние от центра буквы. Если они равны, то сравниваем следующие, и т. д., пока они станут не равны, или строка закончится. Первую и последнюю буквы строки не будем учитывать при проходе во внешнем цикле, где перебираем все центры, так как у первой буквы нет соседней буквы слева, а у последнего &ndash; соседней буквы справа. Также нужно подсчитывать для каждого центра длину палиндрома (равна количеству букв, которые попарно равны от центра + сам центр), и вычислять и хранить максимальную среди них (для этого нужна переменная length), так как нам нужно найти именно максимальный по длине палиндром. Переменная m будет хранить индекс строки, с которой начинается палиндром с длиной length. Вначале length равна единице, а переменная m &ndash; нулю, то есть, если мы не найдем палиндром с длиной 3 или более, то будем считать ответом первый символ строки.</p>
                            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2) Будем искать палиндром, который состоит из четного количества букв, который будет больше по длине, чем тот, что нашли в первом случае. Если его нет, то ответ берем из первого случая, и длина максимального палиндрома уже хранится в переменной length, а позиция, с которой он начинается, &ndash; в переменной m.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Код программы с комментариями:</strong></p>
							<?php
							$counttr=0;
							if (isset($_SESSION['user_id'])) {
								$timusid = $functs->get_timus_id($_SESSION['user_id']);
								$str = "http://acm.timus.ru/status.aspx?space=1&num=1297&author=" . $timusid . "&locale=ru";
								$htmltask = file_get_html($str);
								$exis = $htmltask->find('tr.even');
								$counttr = count($exis);
							}
							if ($counttr>0):
							?>
							<pre class="cpp" style="font-family:monospace;">	<span style="color: #339900;">#include &lt;stdio.h&gt;</span>
	<span style="color: #0000ff;">int</span> main <span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
		<span style="color: #0000ff;">char</span> stroka <span style="color: #008000;">&#91;</span><span style="color: #0000dd;">1001</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">&quot;&quot;</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">int</span> i,k,length,m,pos,x<span style="color: #008080;">;</span>
		<span style="color: #0000dd;">scanf</span> <span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%s&quot;</span>, stroka<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #666666;">// находим количество элементов в считанной строке, сохраняем в переменной pos</span>
		<span style="color: #0000ff;">for</span><span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span><span style="color: #0000dd;">1001</span><span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008000;">&#41;</span><span style="color: #008000;">&#123;</span>
				pos<span style="color: #000080;">=</span>i<span style="color: #008080;">;</span>
				<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
		<span style="color: #008000;">&#125;</span>
&nbsp;
		<span style="color: #666666;">// 1 случай</span>
		length<span style="color: #000080;">=</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
		m<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>x<span style="color: #000080;">=</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> x<span style="color: #000080;">&lt;</span>pos<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> x<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span> <span style="color: #666666;">// внешний цикл, в котором перебираем все центры</span>
			k<span style="color: #000080;">=</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> <span style="color: #666666;">// переменная k хранит расстояние от центра до соседних букв, вначале она 		             </span>
                             <span style="color: #666666;">// равна 1 для кадого центра, потом увеличивается на 1, если соседние</span>
  		             <span style="color: #666666;">// буквы на расстоянии k от центра равны</span>
			<span style="color: #0000ff;">while</span> <span style="color: #008000;">&#40;</span><span style="color: #008000;">&#40;</span>x<span style="color: #000040;">+</span>k<span style="color: #000080;">&lt;</span>pos<span style="color: #008000;">&#41;</span>  <span style="color: #000040;">&amp;&amp;</span> <span style="color: #008000;">&#40;</span>x<span style="color: #000040;">-</span>k<span style="color: #000080;">&gt;=</span><span style="color: #0000dd;">0</span><span style="color: #008000;">&#41;</span><span style="color: #008000;">&#41;</span>
				<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>x<span style="color: #000040;">+</span>k<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span>stroka<span style="color: #008000;">&#91;</span>x<span style="color: #000040;">-</span>k<span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span>
					k<span style="color: #000040;">++</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">else</span> <span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span><span style="color: #008000;">&#40;</span>k<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span><span style="color: #000040;">*</span><span style="color: #0000dd;">2</span><span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #000080;">&gt;</span>length<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span> <span style="color: #666666;">// (k-1)*2+1 – длина палиндрома с центром x</span>
					length<span style="color: #000080;">=</span><span style="color: #008000;">&#40;</span>k<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span><span style="color: #000040;">*</span><span style="color: #0000dd;">2</span><span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
					m<span style="color: #000080;">=</span>x<span style="color: #000040;">-</span>k<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
				<span style="color: #008000;">&#125;</span>
		<span style="color: #008000;">&#125;</span>
&nbsp;
		<span style="color: #666666;">// 2 случай</span>
		<span style="color: #666666;">// сдесь нет центра, так как палиндром будем искать из четного количества букв,</span>
		<span style="color: #666666;">// но есть две центральные буквы, поэтому центром будем считать первую из них</span>
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>x<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> x<span style="color: #000080;">&lt;</span>pos<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> x<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span> <span style="color: #666666;">// последнюю букву не будем учитывать при проходе</span>
			                  <span style="color: #666666;">// по центрам в данном внешнем цикле, так как для этой </span>
				          <span style="color: #666666;">// буквы нет соседнего справа элемента </span>
			k<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
			<span style="color: #0000ff;">while</span> <span style="color: #008000;">&#40;</span><span style="color: #008000;">&#40;</span>x<span style="color: #000040;">+</span>k<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #000080;">&lt;</span>pos<span style="color: #008000;">&#41;</span>  <span style="color: #000040;">&amp;&amp;</span> <span style="color: #008000;">&#40;</span>x<span style="color: #000040;">-</span>k<span style="color: #000080;">&gt;=</span><span style="color: #0000dd;">0</span><span style="color: #008000;">&#41;</span><span style="color: #008000;">&#41;</span>
				<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>x<span style="color: #000040;">-</span>k<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span>stroka<span style="color: #008000;">&#91;</span>x<span style="color: #000040;">+</span>k<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span>
					k<span style="color: #000040;">++</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">else</span> <span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>k<span style="color: #000040;">*</span><span style="color: #0000dd;">2</span><span style="color: #000080;">&gt;</span>length<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span> <span style="color: #666666;">// k*2 – длина палиндрома с центром x</span>
					length<span style="color: #000080;">=</span>k<span style="color: #000040;">*</span><span style="color: #0000dd;">2</span><span style="color: #008080;">;</span>
					m<span style="color: #000080;">=</span>x<span style="color: #000040;">-</span>k<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
				<span style="color: #008000;">&#125;</span>
		<span style="color: #008000;">&#125;</span>
&nbsp;
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span>m<span style="color: #008080;">;</span>i<span style="color: #000080;">&lt;</span>m<span style="color: #000040;">+</span>length<span style="color: #008080;">;</span>i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			<span style="color: #0000dd;">printf</span><span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%c&quot;</span>, stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		<span style="color: #008000;">&#125;</span>
		<span style="color: #0000dd;">printf</span> <span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;<span style="color: #000099; font-weight: bold;">\n</span>&quot;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #0000ff;">return</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
	<span style="color: #008000;">&#125;</span></pre>
							<?php else :
								echo "<p style='color: red;'>Вы не можете просмотреть код программы, пока не было попыток решения этой задачи на сайте acm.timus.ru.</p>";
							endif;
							?>
                        </td>
                    </tr>
                <?php elseif ($number==1354) : ?>
                    <tr>
                        <td>
                            <h2 class="numbersol"><div><a href="http://acm.timus.ru/problem.aspx?space=1&num=1354&locale=ru">1354. Палиндром. Он же палиндром</a></div></h2>
                        </td>
                    </tr>
                    <tr class="textsol">
                        <td>
                            <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Краткое условие:</strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Под словом понимается некоторая непустая последовательность символов. Программа должна считать единственное слово S1 из латинских букв длиной не более 10000. Требуется найти такое непустое слово&nbsp;<em>S</em><sub>2</sub>&nbsp;минимальной длины, что&nbsp;<em>S</em><sub>1</sub><em>S</em><sub>2</sub>&nbsp;&mdash; палиндром. Вывести S1S2.</p>
                            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Идея решения: </strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Как и в задаче 1297, рассмотрим два случая:</p>
                            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1) Сначала будем искать минимальный по длине палиндром, который будет состоять из нечетного количества букв (для этого нужно найти его центр). Если считанное слово S1 уже является палиндромом, то, по условию, нам нужно его дополнить непустым словом S2 до другого палиндрома. Как и в звдаче 1297, будем перебирать возможные центры искомого палиндрома. Поскольку нам не интересен случай, когда слово S1 уже является палиндромом, то нам не интересен центр слова S1. То есть, если у S1 длина 7, то начинаем перебирать возможные центры не с четвертой, а с пятой позиции. Проследив закономерность, находим простую формулу для вычисления номера позиции, от которой начинаем перебирать центры: (pos+1)/2, где pos &ndash; длина считанного слова S1. Для каждого центра проверяем, равны ли соседние буквы от центра на расстоянии k (сначала k равно 1, потом увеличивается на единицу, пока не закончится строка S1 справа). Если хотя бы один раз получаем, что они не равны, то нет смысла дальше увеличивать k и проверять равенство следующих соседних букв. Если, проверяя равенство, достигаем конца строки, то центр найден. Сохраняем его позицию в переменной x. Если центр так и не найден, то x приравниваем к последней позиции строки S1. Переходим ко второму случаю.</p>
                            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2) Будем искать центр палиндрома, который состоит из четного количества букв. Сдесь формула для вычисления номера позиции, от которой начинаем перебирать центры: pos/2.</p>
                            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Как и в задаче 1297, центром считаем первый (левый) из двух центральных символов палиндрома. Найденную позицию центра сохраняем в переменной x1. Если ее так и не находим, то x1 приравниваем к последней позиции строки S1.</p>
                            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Теперь нужно сравнить x и x1. Если x1&lt;x, то x приравниваем к x1, то есть в x у нас теперь хранится центр от которого мы будем считать минимальный палиндром. А в переменную x1 сохраним теперь способ (первый или второй), то есть четность количества букв палиндрома. Это понадобится при выводе ответа.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Код программы с комментариями:</strong></p>
							<?php
							$counttr=0;
							if (isset($_SESSION['user_id'])) {
								$timusid = $functs->get_timus_id($_SESSION['user_id']);
								$str = "http://acm.timus.ru/status.aspx?space=1&num=1354&author=" . $timusid . "&locale=ru";
								$htmltask = file_get_html($str);
								$exis = $htmltask->find('tr.even');
								$counttr = count($exis);
							}
							if ($counttr>0):
							?>
							<pre class="cpp" style="font-family:monospace;">	<span style="color: #339900;">#include &lt;iostream&gt;</span>
	<span style="color: #0000ff;">using</span> <span style="color: #0000ff;">namespace</span> std<span style="color: #008080;">;</span>
&nbsp;
	<span style="color: #0000ff;">int</span> main <span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
		<span style="color: #0000ff;">char</span> stroka <span style="color: #008000;">&#91;</span><span style="color: #0000dd;">10001</span><span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">int</span> i,pos,x,x1,k,find<span style="color: #008080;">;</span>
		<span style="color: #0000dd;">scanf</span> <span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%s&quot;</span>, stroka<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #666666;">// находим длину считанного слова S1</span>
		<span style="color: #0000ff;">for</span><span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span><span style="color: #0000dd;">10001</span><span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008000;">&#41;</span><span style="color: #008000;">&#123;</span>
				pos<span style="color: #000080;">=</span>i<span style="color: #008080;">;</span>
				<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
		<span style="color: #008000;">&#125;</span>
&nbsp;
		<span style="color: #666666;">//1 случай</span>
		find<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> <span style="color: #666666;">//если find равно 0, то центр пока не нашли, а если 1, то нашли</span>
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #008000;">&#40;</span>pos<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span><span style="color: #000040;">/</span><span style="color: #0000dd;">2</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span>pos<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span> <span style="color: #666666;">// внешний цикл для прохода по всем центрам</span>
			<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>find<span style="color: #000080;">==</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span> <span style="color: #666666;">// если центр нашли, то прерываем основной цикл, так как чем 				      </span>
			             <span style="color: #666666;">// левее центр, тем мешьше палиндром, а нам нужен именно</span>
				     <span style="color: #666666;">// палиндром минимальной длины</span>
				<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
			k<span style="color: #000080;">=</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
			<span style="color: #0000ff;">while</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000040;">+</span>k<span style="color: #000080;">&lt;</span>pos<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
				<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span>k<span style="color: #008000;">&#93;</span><span style="color: #000040;">!</span><span style="color: #000080;">=</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">-</span>k<span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span>
					<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">else</span>
					<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000040;">+</span>k<span style="color: #000080;">==</span>pos<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span> <span style="color: #666666;">// если достигли конца строки S1 и все соседние</span>
						          <span style="color: #666666;">// от центра буквы попарно равны,</span>
						find<span style="color: #000080;">=</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>   <span style="color: #666666;">// то считаем, что центр найден</span>
						x<span style="color: #000080;">=</span>i<span style="color: #008080;">;</span>	  <span style="color: #666666;">// сохраняем его позицию</span>
					<span style="color: #008000;">&#125;</span>
					k<span style="color: #000040;">++</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
		<span style="color: #008000;">&#125;</span>
		<span style="color: #666666;">// если центр так и не найден, то x приравниваем к последней позиции строки S1</span>
		<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>find<span style="color: #000080;">==</span><span style="color: #0000dd;">0</span><span style="color: #008000;">&#41;</span>
			x<span style="color: #000080;">=</span>pos<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
		<span style="color: #666666;">//2 случай</span>
		find<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span>pos<span style="color: #000040;">/</span><span style="color: #0000dd;">2</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span>pos<span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>find<span style="color: #000080;">==</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span>
				<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
			k<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
			<span style="color: #0000ff;">while</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000040;">+</span>k<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #000080;">&lt;</span>pos<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
				<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">-</span>k<span style="color: #008000;">&#93;</span><span style="color: #000040;">!</span><span style="color: #000080;">=</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span>k<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span>
					<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">else</span>
					<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000040;">+</span>k<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #000080;">==</span>pos<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
						find<span style="color: #000080;">=</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
						x1<span style="color: #000080;">=</span>i<span style="color: #008080;">;</span>
					<span style="color: #008000;">&#125;</span>
					k<span style="color: #000040;">++</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
		<span style="color: #008000;">&#125;</span>
		<span style="color: #666666;">// если центр так и не найден, то x1 приравниваем к последней позиции строки S1</span>
		<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>find<span style="color: #000080;">==</span><span style="color: #0000dd;">0</span><span style="color: #008000;">&#41;</span>
			x1<span style="color: #000080;">=</span>pos<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #666666;">// вычисляем, какой из центров будет центром меньшего по длине палиндрома, сохраняем 	</span>
		<span style="color: #666666;">// его позицию в переменную x</span>
		<span style="color: #666666;">// в переменную x1 сохраняем четность количества букв искомого палиндрома</span>
		<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>x1<span style="color: #000080;">&lt;</span>x<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			x<span style="color: #000080;">=</span>x1<span style="color: #008080;">;</span>
			x1<span style="color: #000080;">=</span><span style="color: #0000dd;">2</span><span style="color: #008080;">;</span>
		<span style="color: #008000;">&#125;</span>
		<span style="color: #0000ff;">else</span> x1<span style="color: #000080;">=</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #666666;">// вывод ответа</span>
		<span style="color: #666666;">// если S1 - это единственная буква, то правильным ответом будет удвоенная буква</span>
		<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>pos<span style="color: #000080;">==</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			<span style="color: #0000dd;">printf</span><span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%c&quot;</span>, stroka<span style="color: #008000;">&#91;</span><span style="color: #0000dd;">0</span><span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
			<span style="color: #0000dd;">printf</span><span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%c&quot;</span>, stroka<span style="color: #008000;">&#91;</span><span style="color: #0000dd;">0</span><span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		<span style="color: #008000;">&#125;</span>
		<span style="color: #0000ff;">else</span> <span style="color: #008000;">&#123;</span>
			<span style="color: #666666;">// выводим строку S1 до позиции центра, включая его</span>
			<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;=</span>x<span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span>
				<span style="color: #0000dd;">printf</span><span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%c&quot;</span>, stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
			<span style="color: #666666;">// если палиндром должен именть четную длину, то выводим центр еще раз</span>
			<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>x1<span style="color: #000080;">==</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#41;</span>
				<span style="color: #0000dd;">printf</span><span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%c&quot;</span>, stroka<span style="color: #008000;">&#91;</span>x<span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
			<span style="color: #666666;">// выводим строку S1 до позиции центра, но в обратном порядке, получаем палиндром</span>
			<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span>x<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&gt;=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000040;">--</span><span style="color: #008000;">&#41;</span>
				<span style="color: #0000dd;">printf</span><span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%c&quot;</span>, stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		<span style="color: #008000;">&#125;</span>
		<span style="color: #0000dd;">printf</span><span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;<span style="color: #000099; font-weight: bold;">\n</span>&quot;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #666666;">//system (&quot;pause&quot;);</span>
		<span style="color: #0000ff;">return</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
	<span style="color: #008000;">&#125;</span></pre>
							<?php else :
								echo "<p style='color: red;'>Вы не можете просмотреть код программы, пока не было попыток решения этой задачи на сайте acm.timus.ru.</p>";
							endif;
							?>
                        </td>
                    </tr>
                <?php elseif ($number==1102) : ?>
                    <tr>
                        <td>
                            <h2 class="numbersol"><div><a href="http://acm.timus.ru/problem.aspx?space=1&num=1102&locale=ru">1102. Странный диалог</a></div></h2>
                        </td>
                    </tr>
                    <tr class="textsol">
                        <td>
                            <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Краткое условие:</strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Диалогом является строка, которая состоит из слов: &ldquo;one&rdquo;, &ldquo;puton&rdquo;, &ldquo;in&rdquo;, &ldquo;input&rdquo;, &ldquo;out&rdquo;, &ldquo;output&rdquo; в любой последовательности и количестве, без пробелов. Дано&nbsp;<em>N</em>&nbsp;строк. Нужно определить, какие из них являются диалогами. Программа должна считать&nbsp; одно неотрицательное целое число&nbsp;<em>N</em>&nbsp;&le;&nbsp;1000 и затем&nbsp;<em>N</em>&nbsp;строк, которые содержат непустые последовательности строчных латинских букв. Общая длина всех строк не превышает 10<sup>7</sup>&nbsp;символов. Вывод состоит из&nbsp;<em>N</em>&nbsp;строк. Строка содержит слово &quot;YES&quot;, если соответствующая строка ввода является некоторым диалогом, в противном случае строка содержит &quot;NO&quot;.</p>
                            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Идея решения: </strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Будем проходить по строке и вычеркивать из нее слова &ldquo;one&rdquo;, &ldquo;puton&rdquo;, &ldquo;in&rdquo;, &ldquo;input&rdquo;, &ldquo;out&rdquo;, &ldquo;output&rdquo;, то есть каждый символ таких слов заменять на &lsquo;\0&rsquo;. После того, как вычеркнем все слова, пройдем по строке опять, и, если встретим там некоторый символ, отличный от &lsquo;\0&rsquo;, то данная строка не будет являться диалогом, и наоборот.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Допустим, мы начали проходить по строке, начиная от первого символа, и встретили в начале слово &ldquo;put&rdquo;. Мы не знаем, нужно ли его вычеркивать, так как, возможно, за этими буквами будут идти буквы &ldquo;on&rdquo;, и тогда нужно вычеркнуть все слово &ldquo;puton&rdquo; сразу, а не вычеркивать &ldquo;put&rdquo;, а потом расматривать &ldquo;on&rdquo; как часть следующего слова, например слова &ldquo;one&rdquo;.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Поэтому за первый проход по строке мы вычеркиваем только все слова &ldquo;one&rdquo;, которые встретятся. Потому что, если мы встречаем три подряд идущие буквы &lsquo;o&rsquo;, &lsquo;n&rsquo;, &lsquo;e&rsquo;, то они могут принадлежать только этому слову. Буква &lsquo;e&rsquo; в других словах не встречается вообще. Далее идем заново по строке и по такому же принципу вычеркиваем все слова &ldquo;puton&rdquo;. Затем можно вычеркнуть за один следующий проход слова &ldquo;input&rdquo; и &ldquo;output&rdquo;, и за последний проход &ndash; &ldquo;in&rdquo; и &ldquo;out&rdquo;.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Код программы с комментариями:</strong></p>
							<?php
							$counttr=0;
							if (isset($_SESSION['user_id'])) {
								$timusid = $functs->get_timus_id($_SESSION['user_id']);
								$str = "http://acm.timus.ru/status.aspx?space=1&num=1102&author=" . $timusid . "&locale=ru";
								$htmltask = file_get_html($str);
								$exis = $htmltask->find('tr.even');
								$counttr = count($exis);
							}
							if ($counttr>0):
							?>
							<pre class="cpp" style="font-family:monospace;">	<span style="color: #339900;">#include &lt;iostream&gt;;</span>
	<span style="color: #0000ff;">using</span> <span style="color: #0000ff;">namespace</span> std<span style="color: #008080;">;</span>
&nbsp;
	<span style="color: #0000ff;">int</span> main <span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
		<span style="color: #0000ff;">const</span> <span style="color: #0000ff;">int</span> M<span style="color: #000080;">=</span><span style="color: #0000dd;">10000001</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">char</span><span style="color: #000040;">*</span> stroka<span style="color: #000080;">=</span><span style="color: #0000dd;">new</span> <span style="color: #0000ff;">char</span><span style="color: #008000;">&#91;</span>M<span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">int</span> N,j,i,pos<span style="color: #008080;">;</span>
		<span style="color: #0000dd;">scanf</span> <span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%d&quot;</span>, <span style="color: #000040;">&amp;</span>N<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span> <span style="color: #666666;">// считываем количество строк</span>
		<span style="color: #666666;">// будем считывать очередную строку и сразу отвечать на вопрос, является ли она 	</span>
		<span style="color: #666666;">// диалогом</span>
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>j<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> j<span style="color: #000080;">&lt;</span>N<span style="color: #008080;">;</span>j<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
&nbsp;
			<span style="color: #0000dd;">scanf</span> <span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%s&quot;</span>, stroka<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
			pos <span style="color: #000080;">=</span> <span style="color: #0000dd;">strlen</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
&nbsp;
			<span style="color: #666666;">// находим и удаляем все слова &quot;one&quot; со строки</span>
			<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span>pos<span style="color: #000040;">-</span><span style="color: #0000dd;">2</span><span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span>
				<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'o'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'n'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'e'</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
					stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
					stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
					stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
				<span style="color: #008000;">&#125;</span>
&nbsp;
				<span style="color: #666666;">// находим и удаляем все слова &quot;puton&quot; со строки</span>
				<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span>pos<span style="color: #000040;">-</span><span style="color: #0000dd;">4</span><span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span>
					<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'p'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'u'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'t'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">3</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'o'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">4</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'n'</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
						stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
						stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
						stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
						stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">3</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
						stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">4</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
					<span style="color: #008000;">&#125;</span>
&nbsp;
					<span style="color: #666666;">// находим и удаляем все слова &quot;input&quot; и &quot;output&quot; со строки</span>
					<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span>pos<span style="color: #000040;">-</span><span style="color: #0000dd;">4</span><span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
						<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'i'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'n'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'p'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">3</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'u'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">4</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'t'</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">3</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">4</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
						<span style="color: #008000;">&#125;</span>
						<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'o'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'u'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'t'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">3</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'p'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">4</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'u'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">5</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'t'</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">3</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">4</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">5</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
						<span style="color: #008000;">&#125;</span>
					<span style="color: #008000;">&#125;</span>
&nbsp;
					<span style="color: #666666;">// находим и удаляем все слова &quot;in&quot; и &quot;out&quot; со строки</span>
					<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span>pos<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
						<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'i'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'n'</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
						<span style="color: #008000;">&#125;</span>
						<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'o'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'u'</span> <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'t'</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
							stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008080;">;</span>
						<span style="color: #008000;">&#125;</span>
					<span style="color: #008000;">&#125;</span>
&nbsp;
					<span style="color: #666666;">//вывод ответа для текущей строки</span>
					<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span>pos<span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span>
						<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>stroka<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000040;">!</span><span style="color: #000080;">=</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
							<span style="color: #0000dd;">cout</span><span style="color: #000080;">&lt;&lt;</span><span style="color: #FF0000;">&quot;NO<span style="color: #000099; font-weight: bold;">\n</span>&quot;</span><span style="color: #008080;">;</span>
							<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
						<span style="color: #008000;">&#125;</span>
						<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">==</span>pos <span style="color: #000040;">&amp;&amp;</span> stroka<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span><span style="color: #FF0000;">'<span style="color: #006699; font-weight: bold;">\0</span>'</span><span style="color: #008000;">&#41;</span>
							<span style="color: #0000dd;">cout</span><span style="color: #000080;">&lt;&lt;</span><span style="color: #FF0000;">&quot;YES<span style="color: #000099; font-weight: bold;">\n</span>&quot;</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #008000;">&#125;</span>
&nbsp;
		<span style="color: #0000dd;">delete</span> <span style="color: #008000;">&#91;</span><span style="color: #008000;">&#93;</span> stroka<span style="color: #008080;">;</span>
		<span style="color: #666666;">//system(&quot;pause&quot;);</span>
		<span style="color: #0000ff;">return</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
	<span style="color: #008000;">&#125;</span></pre>
							<?php else :
								echo "<p style='color: red;'>Вы не можете просмотреть код программы, пока не было попыток решения этой задачи на сайте acm.timus.ru.</p>";
							endif;
							?>
                        </td>
                    </tr>
                <?php elseif ($number==1684) : ?>
                    <tr>
                        <td>
                            <h2 class="numbersol"><div><a href="http://acm.timus.ru/problem.aspx?space=1&num=1684&locale=ru">1684. Последнее слово Джека</a></div></h2>
                        </td>
                    </tr>
                    <tr class="textsol">
                        <td>
                            <p><strong style="line-height:1.6em">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Краткое условие:</strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Программа должна считать две строки из строчных латинских букв, каждое из которых длиной не более 75000. Если вторую строку можно разбить на несколько частей, каждая из которых является первой строкой или ее непустым префиксом&nbsp;&mdash; вывести первой строкой &ldquo;No&rdquo; и все эти части во второй строке, разделяя их пробелом. Если же такого разбиения нет, вывести единственной строкой &laquo;Yes&raquo;.</p>
                            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Идея решения: </strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; В данной задаче будет использоваться алгоритм построения z-функции за линейное время. Пусть некоторая строка S имеет длину N. Тогда z-функция, построенная для этой строки &ndash; это массив длины N, i-й элемент которого равен длине подстроки, начинающейся в позиции i, которая равна префиксу этой строки, причем эта длина должна быть максимальная из всех возможных.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Пусть считано две строки Str1 и Str2, имеющие длины N, M соответственно. Построим z-функцию (массив z_f) для строки t=Str1+&rsquo; &lsquo;+Str2, где &rsquo; &lsquo;- разделитель. Начиная с позиции i=N+1 значения массива z_f&nbsp; равны количеству символов строки t от позиции i, которые равны префиксу этой строки t. Что то же самое, что и количество символов строки Str2 от позиции i-N-1, которые равны префиксу строки Str1.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Идея поиска ответа на задачу в том, что если эти значения массива z_f&nbsp; перекрывают все символы строки Str2, то это значит, что строка Str2 состоит из префиксов строки Str1 и ответом будет &ldquo;No&rdquo;, а если нет &ndash; то &ldquo;Yes&rdquo;.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Пусть значение z_f[i]=5. Тогда это значение перекрывает такие индексы строки t: (i; i+5-1), т.е. в общем виде (i;i+z_f[i]-1), и отсюда получаем, что это значение перекрывает такие индексы строки Str2: (i-N-1; i-N-1+z_f[i]-1). Будем высчитывать для каждого i, начиная от N+1, значение правой границы r= i+z_f[i]-1, по которое покрывается строка Str2 в строке t. А также будем в переменной max_r хранить максимальное из значений r, чтобы знать, по какой индекс точно покрывается эта строка.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Для ответа на вопрос, как именно разбить строку Str2, чтоб из нее получить префиксы Str1, если это вообще можно сделать, нам понадобится массив mas, в котором будут индексы строки Str2 в строке t, которые разбивают ее.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Код программы с комментариями:</strong></p>
							<?php
							$counttr=0;
							if (isset($_SESSION['user_id'])) {
								$timusid = $functs->get_timus_id($_SESSION['user_id']);
								$str = "http://acm.timus.ru/status.aspx?space=1&num=1684&author=" . $timusid . "&locale=ru";
								$htmltask = file_get_html($str);
								$exis = $htmltask->find('tr.even');
								$counttr = count($exis);
							}
							if ($counttr>0):
							?>
							<pre class="cpp" style="font-family:monospace;">	<span style="color: #339900;">#include &lt;iostream&gt;</span>
	<span style="color: #339900;">#include &lt;vector&gt;</span>
	<span style="color: #0000ff;">using</span> <span style="color: #0000ff;">namespace</span> std<span style="color: #008080;">;</span>
	<span style="color: #339900;">#include &lt;string&gt;</span>
&nbsp;
	<span style="color: #666666;">// функция для построения z-функции заданной строки</span>
	vector<span style="color: #000080;">&lt;</span><span style="color: #0000ff;">int</span><span style="color: #000080;">&gt;</span> z_function <span style="color: #008000;">&#40;</span>string s<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
		<span style="color: #0000ff;">int</span> len <span style="color: #000080;">=</span><span style="color: #008000;">&#40;</span><span style="color: #0000ff;">int</span><span style="color: #008000;">&#41;</span> s.<span style="color: #007788;">length</span><span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		vector<span style="color: #000080;">&lt;</span><span style="color: #0000ff;">int</span><span style="color: #000080;">&gt;</span> z<span style="color: #008000;">&#40;</span>len<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">int</span> l <span style="color: #000080;">=</span> <span style="color: #0000dd;">0</span>, r <span style="color: #000080;">=</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">int</span> j<span style="color: #008080;">;</span>
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span><span style="color: #0000ff;">int</span> i <span style="color: #000080;">=</span> <span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> i <span style="color: #000080;">&lt;</span> len<span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span>
			<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>i <span style="color: #000080;">&gt;</span> r<span style="color: #008000;">&#41;</span><span style="color: #008000;">&#123;</span>
				j <span style="color: #000080;">=</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">while</span> <span style="color: #008000;">&#40;</span>j <span style="color: #000040;">+</span> i <span style="color: #000080;">&lt;</span> len<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
					<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>s<span style="color: #008000;">&#91;</span>i <span style="color: #000040;">+</span> j<span style="color: #008000;">&#93;</span> <span style="color: #000080;">==</span> s<span style="color: #008000;">&#91;</span>j<span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span>
						j<span style="color: #000040;">++</span><span style="color: #008080;">;</span>
					<span style="color: #0000ff;">else</span>
						<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
				<span style="color: #008000;">&#125;</span>
				z<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span> <span style="color: #000080;">=</span> j<span style="color: #008080;">;</span>
				l <span style="color: #000080;">=</span> i<span style="color: #008080;">;</span>
				r <span style="color: #000080;">=</span> i <span style="color: #000040;">+</span> j <span style="color: #000040;">-</span> <span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
			<span style="color: #0000ff;">else</span>
				<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>z<span style="color: #008000;">&#91;</span>i <span style="color: #000040;">-</span> l<span style="color: #008000;">&#93;</span> <span style="color: #000080;">&lt;</span> r <span style="color: #000040;">-</span> i <span style="color: #000040;">+</span> <span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span>
					z<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span> <span style="color: #000080;">=</span> z<span style="color: #008000;">&#91;</span>i <span style="color: #000040;">-</span> l<span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">else</span><span style="color: #008000;">&#123;</span>
					j <span style="color: #000080;">=</span> <span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
					<span style="color: #0000ff;">while</span> <span style="color: #008000;">&#40;</span>j <span style="color: #000040;">+</span> r <span style="color: #000080;">&lt;</span> len<span style="color: #008000;">&#41;</span>
						<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>s<span style="color: #008000;">&#91;</span>r <span style="color: #000040;">+</span> j<span style="color: #008000;">&#93;</span> <span style="color: #000080;">==</span> s<span style="color: #008000;">&#91;</span>r <span style="color: #000040;">-</span> i <span style="color: #000040;">+</span> j<span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span>
							j<span style="color: #000040;">++</span><span style="color: #008080;">;</span>
						<span style="color: #0000ff;">else</span>
							<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
					z<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span> <span style="color: #000080;">=</span> r <span style="color: #000040;">-</span> i <span style="color: #000040;">+</span> j<span style="color: #008080;">;</span>
					l <span style="color: #000080;">=</span> i<span style="color: #008080;">;</span>
					r <span style="color: #000080;">=</span> r <span style="color: #000040;">+</span> j <span style="color: #000040;">-</span> <span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
				<span style="color: #008000;">&#125;</span>
				<span style="color: #0000ff;">return</span> z<span style="color: #008080;">;</span>
	<span style="color: #008000;">&#125;</span>
&nbsp;
	<span style="color: #0000ff;">int</span> main <span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
		<span style="color: #0000ff;">int</span> i,r,max_r,N,M,k<span style="color: #008080;">;</span>
		string Str1<span style="color: #008080;">;</span>
		string Str2<span style="color: #008080;">;</span>
		<span style="color: #0000dd;">cin</span><span style="color: #000080;">&gt;&gt;</span>Str1<span style="color: #008080;">;</span>
		<span style="color: #0000dd;">cin</span><span style="color: #000080;">&gt;&gt;</span>Str2<span style="color: #008080;">;</span>
		N <span style="color: #000080;">=</span><span style="color: #008000;">&#40;</span><span style="color: #0000ff;">int</span><span style="color: #008000;">&#41;</span> Str1.<span style="color: #007788;">length</span><span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		M <span style="color: #000080;">=</span><span style="color: #008000;">&#40;</span><span style="color: #0000ff;">int</span><span style="color: #008000;">&#41;</span> Str2.<span style="color: #007788;">length</span><span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">int</span> mas<span style="color: #008000;">&#91;</span><span style="color: #0000dd;">75000</span><span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>
&nbsp;
		vector<span style="color: #000080;">&lt;</span><span style="color: #0000ff;">int</span><span style="color: #000080;">&gt;</span> z_f<span style="color: #008000;">&#40;</span>N<span style="color: #000040;">+</span>M<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #666666;">// строим z-функцию строки t=Str1+' '+Str2</span>
		z_f<span style="color: #000080;">=</span>z_function<span style="color: #008000;">&#40;</span>Str1<span style="color: #000040;">+</span><span style="color: #FF0000;">' '</span><span style="color: #000040;">+</span>Str2<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
&nbsp;
		max_r<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> <span style="color: #666666;">//обнуляем переменную для хранения максимальной из правых границ</span>
		k<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>  <span style="color: #666666;">// переменная для продвижения по массиву mas</span>
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span>N<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span>N<span style="color: #000040;">+</span>M<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			r<span style="color: #000080;">=</span>i<span style="color: #000040;">+</span>z_f<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> <span style="color: #666666;">// высчитываем правую границу для очередного значения i</span>
			<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>r<span style="color: #000080;">==</span>i<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span> <span style="color: #000040;">&amp;&amp;</span> i<span style="color: #000080;">&gt;</span>max_r<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span> <span style="color: #666666;">// если правая граница не покрывает текущий символ i </span>
				                 <span style="color: #666666;">// и max_r тоже его не покрывает,</span>
				<span style="color: #0000dd;">cout</span><span style="color: #000080;">&lt;&lt;</span><span style="color: #FF0000;">&quot;Yes<span style="color: #000099; font-weight: bold;">\n</span>&quot;</span><span style="color: #008080;">;</span>   <span style="color: #666666;">// то строка Str2 состоит не только исключительно из 					  </span>
                                                 <span style="color: #666666;">// префиксов строки Str1, и можно сразу вывести ответ, 					  </span>
                                                 <span style="color: #666666;">// и прекратить поиск				</span>
				<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
			<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>r<span style="color: #000080;">&gt;</span>max_r<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>   <span style="color: #666666;">// если нашли бОльшую правую границу</span>
				max_r<span style="color: #000080;">=</span>r<span style="color: #008080;">;</span> <span style="color: #666666;">// обновляем переменную max_r</span>
				mas<span style="color: #008000;">&#91;</span>k<span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span>i<span style="color: #008080;">;</span> <span style="color: #666666;">// k-ый элемент массива mas будет означать, что строка t</span>
 					  <span style="color: #666666;">// разбивается на части t(mas[k];mas[k+1]), т. е. то же самое, 				   </span>
                                          <span style="color: #666666;">// что и строка Str2 - на части Str2(mas[k]-N-1;mas[k+1]-N-1)</span>
				k<span style="color: #000040;">++</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
		<span style="color: #008000;">&#125;</span>
&nbsp;
		mas<span style="color: #008000;">&#91;</span>k<span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span>N<span style="color: #000040;">+</span>M<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> <span style="color: #666666;">// для удобства вывода разбиения строки Str2</span>
		<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">==</span>N<span style="color: #000040;">+</span>M<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>       <span style="color: #666666;">// если достигли конца массива, то ответ &quot;Yes&quot; мы так и не нашли,</span>
			<span style="color: #0000dd;">cout</span><span style="color: #000080;">&lt;&lt;</span><span style="color: #FF0000;">&quot;No<span style="color: #000099; font-weight: bold;">\n</span>&quot;</span><span style="color: #008080;">;</span> <span style="color: #666666;">// значит ответ - &quot;No&quot; и выводим разбиение строки Str2:</span>
			<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> i<span style="color: #000080;">&lt;</span>k<span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
				<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span><span style="color: #0000ff;">int</span> j<span style="color: #000080;">=</span>mas<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span> j<span style="color: #000080;">&lt;</span>mas<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span> j<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span>
					<span style="color: #0000dd;">cout</span><span style="color: #000080;">&lt;&lt;</span>Str2<span style="color: #008000;">&#91;</span>j<span style="color: #000040;">-</span>N<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>
				<span style="color: #0000dd;">cout</span><span style="color: #000080;">&lt;&lt;</span><span style="color: #FF0000;">' '</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
			<span style="color: #0000dd;">cout</span><span style="color: #000080;">&lt;&lt;</span><span style="color: #FF0000;">'<span style="color: #000099; font-weight: bold;">\n</span>'</span><span style="color: #008080;">;</span>
		<span style="color: #008000;">&#125;</span>
&nbsp;
		<span style="color: #666666;">//system (&quot;pause&quot;);</span>
		<span style="color: #0000ff;">return</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
	<span style="color: #008000;">&#125;</span></pre>
							<?php else :
								echo "<p style='color: red;'>Вы не можете просмотреть код программы, пока не было попыток решения этой задачи на сайте acm.timus.ru.</p>";
							endif;
							?>
                        </td>
                    </tr>
                <?php elseif ($number==1423) : ?>
                    <tr>
                        <td>
                            <h2 class="numbersol"><div><a href="http://acm.timus.ru/problem.aspx?space=1&num=1423&locale=ru">1423. Басня о строке</a></div></h2>
                        </td>
                    </tr>
                    <tr class="textsol">
                        <td>
                            <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Краткое условие:</strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Под циклическим сдвигом строки понимается перенос её последнего символа в начало. Программа должна считать три строки. Первая строка содержит целое число N (1 &le; N &le; 250000). Вторая строка содержит строку S. Третья строка содержит строку T. Обе строки имеют длину N и могут содержать любые символы таблицы ASCII с кодами от 33 до 255. Если строка T может быть получена из строки S с помощью циклических сдвигов, вывести их количество X, где 0 &le; X &lt; N, иначе вывести &laquo;&minus;1&raquo;. Если задача имеет несколько решений, можно вывести любое из них.</p>
                            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Идея решения: </strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Если найдем позицию i, начиная с которой префикс строки T входит в S, пока S не закончится, и оставшаяся часть строки T совпадает с префиксом S, то, если от количества букв в строке S отнимем найденную позицию i, получим ответ (количество циклических сдвигов, которые нужно произвести над строкой S, чтобы получить строку T).</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Для того, чтобы позицию i было найти проще, склеим две строки S, и будем искать в такой удвоенной строке S подстроку T. Для нахождения подстроки в строке используем алгоритмы: <strong>1) построения </strong><strong>z</strong><strong>-функции</strong> (это массив длины N, i-ый элемент которого равен наибольшему числу символов, начиная с позиции&nbsp;i, совпадающих с первыми символами строки&nbsp;S). <strong>2)</strong> <strong>п</strong><strong>оиск подстроки в строке</strong><strong>.</strong></p>
                            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Алгоритм п</strong><strong>оиск</strong><strong>а</strong><strong> подстроки в строке</strong><strong> с использованием </strong><strong>z</strong><strong>-функции:</strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Задача заключается в том, чтоб найти вхождение подстроки T в удвоенную строку S. Для решения этой задачи образуем строку&nbsp;T+&lsquo; &lsquo;+S+S, &lsquo; &lsquo; - символ-разделитель (который не встречается нигде в самих строках). Посчитаем для полученной строки Z-функцию. Таким образом, получили массив длины 3*N+1, i-ый элемент которого равен наибольшему числу символов, начиная с позиции&nbsp;i, совпадающих с началом строки&nbsp;T+&lsquo; &lsquo;+S+S. Если i-ый элемент массива-z-функции равен N, то значит, начиная с позиции i, строка T входит в строку T+&lsquo; &lsquo;+S+S.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Теперь, если от места, где заканчивается строка T+&lsquo; &lsquo;+S, отнять i, то получим количество циклических сдвигов, которые нужно произвести над строкой S, чтобы получить строку T. То есть ответом будет значение выражения 2*N+1-i.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Код программы с комментариями:</strong></p>
							<?php
							$counttr=0;
							if (isset($_SESSION['user_id'])) {
								$timusid = $functs->get_timus_id($_SESSION['user_id']);
								$str = "http://acm.timus.ru/status.aspx?space=1&num=1423&author=" . $timusid . "&locale=ru";
								$htmltask = file_get_html($str);
								$exis = $htmltask->find('tr.even');
								$counttr = count($exis);
							}
							if ($counttr>0):
							?>
							<pre class="cpp" style="font-family:monospace;">	<span style="color: #339900;">#include &lt;iostream&gt;</span>
	<span style="color: #339900;">#include &lt;vector&gt;</span>
	<span style="color: #0000ff;">using</span> <span style="color: #0000ff;">namespace</span> std<span style="color: #008080;">;</span>
	<span style="color: #339900;">#include &lt;string&gt;</span>
&nbsp;
	<span style="color: #666666;">// функция, которая принимает строку и возвращает z-функцию этой строки</span>
	vector<span style="color: #000080;">&lt;</span><span style="color: #0000ff;">int</span><span style="color: #000080;">&gt;</span> z_function <span style="color: #008000;">&#40;</span>string s<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
		<span style="color: #0000ff;">int</span> len <span style="color: #000080;">=</span><span style="color: #008000;">&#40;</span><span style="color: #0000ff;">int</span><span style="color: #008000;">&#41;</span> s.<span style="color: #007788;">length</span><span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		vector<span style="color: #000080;">&lt;</span><span style="color: #0000ff;">int</span><span style="color: #000080;">&gt;</span> z<span style="color: #008000;">&#40;</span>len<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">int</span> l <span style="color: #000080;">=</span> <span style="color: #0000dd;">0</span>, r <span style="color: #000080;">=</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">int</span> j<span style="color: #008080;">;</span>
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span><span style="color: #0000ff;">int</span> i <span style="color: #000080;">=</span> <span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> i <span style="color: #000080;">&lt;</span> len<span style="color: #008080;">;</span> i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span>
			<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>i <span style="color: #000080;">&gt;</span> r<span style="color: #008000;">&#41;</span><span style="color: #008000;">&#123;</span>
				j <span style="color: #000080;">=</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">while</span> <span style="color: #008000;">&#40;</span>j <span style="color: #000040;">+</span> i <span style="color: #000080;">&lt;</span> len<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
					<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>s<span style="color: #008000;">&#91;</span>i <span style="color: #000040;">+</span> j<span style="color: #008000;">&#93;</span> <span style="color: #000080;">==</span> s<span style="color: #008000;">&#91;</span>j<span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span>
						j<span style="color: #000040;">++</span><span style="color: #008080;">;</span>
					<span style="color: #0000ff;">else</span>
						<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
				<span style="color: #008000;">&#125;</span>
				z<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span> <span style="color: #000080;">=</span> j<span style="color: #008080;">;</span>
				l <span style="color: #000080;">=</span> i<span style="color: #008080;">;</span>
				r <span style="color: #000080;">=</span> i <span style="color: #000040;">+</span> j <span style="color: #000040;">-</span> <span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
			<span style="color: #0000ff;">else</span>
				<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>z<span style="color: #008000;">&#91;</span>i <span style="color: #000040;">-</span> l<span style="color: #008000;">&#93;</span> <span style="color: #000080;">&lt;</span> r <span style="color: #000040;">-</span> i <span style="color: #000040;">+</span> <span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span>
					z<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span> <span style="color: #000080;">=</span> z<span style="color: #008000;">&#91;</span>i <span style="color: #000040;">-</span> l<span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">else</span><span style="color: #008000;">&#123;</span>
					j <span style="color: #000080;">=</span> <span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
					<span style="color: #0000ff;">while</span> <span style="color: #008000;">&#40;</span>j <span style="color: #000040;">+</span> r <span style="color: #000080;">&lt;</span> len<span style="color: #008000;">&#41;</span>
						<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>s<span style="color: #008000;">&#91;</span>r <span style="color: #000040;">+</span> j<span style="color: #008000;">&#93;</span> <span style="color: #000080;">==</span> s<span style="color: #008000;">&#91;</span>r <span style="color: #000040;">-</span> i <span style="color: #000040;">+</span> j<span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span>
							j<span style="color: #000040;">++</span><span style="color: #008080;">;</span>
						<span style="color: #0000ff;">else</span>
							<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
					z<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span> <span style="color: #000080;">=</span> r <span style="color: #000040;">-</span> i <span style="color: #000040;">+</span> j<span style="color: #008080;">;</span>
					l <span style="color: #000080;">=</span> i<span style="color: #008080;">;</span>
					r <span style="color: #000080;">=</span> r <span style="color: #000040;">+</span> j <span style="color: #000040;">-</span> <span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
				<span style="color: #008000;">&#125;</span>
				<span style="color: #0000ff;">return</span> z<span style="color: #008080;">;</span>
	<span style="color: #008000;">&#125;</span>
&nbsp;
	<span style="color: #0000ff;">int</span> main <span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
		<span style="color: #0000ff;">int</span> i,N,otvet<span style="color: #000080;">=</span><span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
		<span style="color: #0000dd;">scanf</span> <span style="color: #008000;">&#40;</span><span style="color: #FF0000;">&quot;%d&quot;</span>,<span style="color: #000040;">&amp;</span>N<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		string Str1<span style="color: #008080;">;</span>
		string Str2<span style="color: #008080;">;</span>
		<span style="color: #0000dd;">cin</span><span style="color: #000080;">&gt;&gt;</span><span style="color: #008000;">&#40;</span>Str1<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		<span style="color: #0000dd;">cin</span><span style="color: #000080;">&gt;&gt;</span><span style="color: #008000;">&#40;</span>Str2<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		vector<span style="color: #000080;">&lt;</span><span style="color: #0000ff;">int</span><span style="color: #000080;">&gt;</span> z_f<span style="color: #008000;">&#40;</span><span style="color: #0000dd;">3</span><span style="color: #000040;">*</span>N<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span> <span style="color: #666666;">// объявляем вектор размером 3*N+1 для хранения z-функции</span>
 				        <span style="color: #666666;">// строки</span>
&nbsp;
		z_f<span style="color: #000080;">=</span>z_function<span style="color: #008000;">&#40;</span>Str2<span style="color: #000040;">+</span><span style="color: #FF0000;">' '</span><span style="color: #000040;">+</span>Str1<span style="color: #000040;">+</span>Str1<span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span> <span style="color: #666666;">// стороим z-функцию строки, состоящей из</span>
 					            <span style="color: #666666;">// склеенных строк Str2, пробела и двух строк </span>
		                                    <span style="color: #666666;">// Str1, и сохраняем в вектор z_f</span>
&nbsp;
		<span style="color: #666666;">// проходим по вектору z_f, начиная с позиции, где z-функция соответствует первой</span>
 	        <span style="color: #666666;">// строке Str1:</span>
		<span style="color: #0000ff;">for</span><span style="color: #008000;">&#40;</span>i<span style="color: #000080;">=</span>N<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>i<span style="color: #000080;">&lt;</span><span style="color: #0000dd;">3</span><span style="color: #000040;">*</span>N<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>i<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>z_f<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span><span style="color: #000080;">==</span>N<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span> <span style="color: #666666;">// когда находим значение z-функции, равное N, эта позиция - 				   </span>
                                         <span style="color: #666666;">// вхождения строки Str2 в Str1</span>
				otvet<span style="color: #000080;">=</span><span style="color: #0000dd;">2</span><span style="color: #000040;">*</span>N<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #000040;">-</span>i<span style="color: #008080;">;</span> <span style="color: #666666;">// находим количество циклических сдвигов</span>
				<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>otvet<span style="color: #000080;">==</span>N<span style="color: #008000;">&#41;</span>  <span style="color: #666666;">// если циклических сдвигов столько же, какая длина</span>
 					       <span style="color: #666666;">// строки, то заменяем это число на 0, так как по</span>
					       <span style="color: #666666;">// условию количество должно быть меньше N, и если мы </span>
					       <span style="color: #666666;">// производим над строкой N циклических сдвигов, то это 					</span>
                                               <span style="color: #666666;">// дает ту же строку, как если бы не производили их вообще</span>
					otvet<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">break</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span>
		<span style="color: #008000;">&#125;</span>
		<span style="color: #0000dd;">cout</span><span style="color: #000080;">&lt;&lt;</span>otvet<span style="color: #000080;">&lt;&lt;</span><span style="color: #FF0000;">'<span style="color: #000099; font-weight: bold;">\n</span>'</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #666666;">//system (&quot;pause&quot;);</span>
		<span style="color: #0000ff;">return</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
	<span style="color: #008000;">&#125;</span></pre>
							<?php else :
								echo "<p style='color: red;'>Вы не можете просмотреть код программы, пока не было попыток решения этой задачи на сайте acm.timus.ru.</p>";
							endif;
							?>
                        </td>
                    </tr>
                <?php elseif ($number==1590) : ?>
                    <tr>
                        <td>
                            <h2 class="numbersol"><div><a href="http://acm.timus.ru/problem.aspx?space=1&num=1590&locale=ru">1590. Шифр Бэкона</a></div></h2>
                        </td>
                    </tr>
                    <tr class="textsol">
                        <td>
                            <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Краткое условие:</strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; На входе дана непустая строка, которая состоит только из строчных латинских символов. Ее длина не превосходит 5000 символов. Вывести количество различных подстрок этой строки.</p>
                            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Идея решения: </strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; В данной задаче будет использоваться алгоритм построения префикс-функции за линейное время. Пусть некоторая строка S имеет длину N. Тогда префикс-функция, построенная для этой строки &ndash; это массив длины N, i-й элемент которого равен длине суффикса подстроки, заканчивающегося в позиции i, который равен префиксу этой строки, причем эта длина должна быть максимальная из всех возможных, а суффикс не должен совпадать со всей строкой.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Требуется посчитать количество различных подстрок строки S. Научимся, зная текущее количество различных подстрок строки S (i;N-1), пересчитывать это количество при расширении этой строки на 1 символ, т.е. для строки S (i-1;N-1). Итак, пусть k&nbsp;&nbsp;&mdash; текущее количество различных подстрок строки S (i;N-1), и мы хотим посчитать новое количество подстрок при добавлении i-1-го&nbsp;символа c. Очевидно, в результате могли появиться некоторые новые подстроки, начинающиеся с этого нового символа&nbsp;c. А именно, добавляются в качестве новых те подстроки, начинающиеся с символа&nbsp;c и не встречавшиеся далее.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Наша задача &mdash; посчитать, сколько у строки&nbsp;S (i-1;N-1)&nbsp;таких префиксов, которые не встречаются в ней более нигде. Но если мы посчитаем для строки&nbsp;S (i-1;N-1) префикс-функцию p(i-1;N-1) и найдём её максимальное значение&nbsp;p<sub>max</sub>, то, очевидно, в строке S (i-1;N-1) встречается (не в начале) её префикс длины&nbsp;p<sub>max</sub>, но не большей длины. Понятно, префиксы меньшей длины уж точно встречаются в ней.</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Итак, мы получили, что число новых подстрок, появляющихся с учетом нового символа&nbsp;c, равно&nbsp;S (i-1;N-1).length( )+1-p<sub>max</sub>.</p>
                            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Код программы с комментариями:</strong></p>
							<?php
							$counttr=0;
							if (isset($_SESSION['user_id'])) {
								$timusid = $functs->get_timus_id($_SESSION['user_id']);
								$str = "http://acm.timus.ru/status.aspx?space=1&num=1590&author=" . $timusid . "&locale=ru";
								$htmltask = file_get_html($str);
								$exis = $htmltask->find('tr.even');
								$counttr = count($exis);
							}
							if ($counttr>0):
							?>
							<pre class="cpp" style="font-family:monospace;">	<span style="color: #339900;">#include &lt;iostream&gt;</span>
	<span style="color: #0000ff;">using</span> <span style="color: #0000ff;">namespace</span> std<span style="color: #008080;">;</span>
	<span style="color: #339900;">#include &lt;string&gt;</span>
&nbsp;
	<span style="color: #0000ff;">int</span> main <span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
		string str<span style="color: #008080;">;</span>
		<span style="color: #0000dd;">cin</span><span style="color: #000080;">&gt;&gt;</span>str<span style="color: #008080;">;</span>
		<span style="color: #0000ff;">int</span> N <span style="color: #000080;">=</span> str.<span style="color: #007788;">length</span><span style="color: #008000;">&#40;</span><span style="color: #008000;">&#41;</span><span style="color: #008080;">;</span>
		<span style="color: #0000ff;">int</span> i,j,k,max,count<span style="color: #000080;">=</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span>
		<span style="color: #666666;">// перемення count нужна для хранения количества различных пдстрок очередной строки,</span>
		<span style="color: #666666;">// вначале count=1, так как из последней буквы строки можно составить только одну </span>
		<span style="color: #666666;">// подстроку. Следующая строка, для которой будем искать количество различных 	</span>
		<span style="color: #666666;">// подстрок, состоит из двух последних букв строки, следующая - из трех последних, </span>
         	<span style="color: #666666;">// и т.д. Для всех этих строк будут строится префикс-функции</span>
		<span style="color: #0000ff;">int</span><span style="color: #000040;">*</span> p <span style="color: #000080;">=</span> <span style="color: #0000dd;">new</span> <span style="color: #0000ff;">int</span> <span style="color: #008000;">&#91;</span>N<span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #0000ff;">for</span> <span style="color: #008000;">&#40;</span>k<span style="color: #000080;">=</span><span style="color: #0000dd;">1</span><span style="color: #008080;">;</span> k<span style="color: #000080;">&lt;</span>N<span style="color: #008080;">;</span> k<span style="color: #000040;">++</span><span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
			i<span style="color: #000080;">=</span>N<span style="color: #000040;">-</span>k<span style="color: #008080;">;</span> <span style="color: #666666;">// i указывает на второй элемент очередной строки, для которой ниже </span>
			       <span style="color: #666666;">// будем строить префикс-функцию</span>
			p<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> <span style="color: #666666;">// первый элемент префикс-функции всегда равен 0</span>
			max<span style="color: #000080;">=</span><span style="color: #0000dd;">0</span><span style="color: #008080;">;</span> <span style="color: #666666;">// переменная для хранения максимального значения очередной префикс-функции</span>
&nbsp;
                        <span style="color: #666666;">// построение префикс-функции p(N-k-1;N-1) для строки str(N-k-1;N-1)</span>
			<span style="color: #666666;">// то есть префикс-функция p(N-k-1;N-1) смещена на N-k-1 от начала массива p[ ]</span>
			<span style="color: #0000ff;">while</span> <span style="color: #008000;">&#40;</span>i<span style="color: #000080;">&lt;</span>N<span style="color: #008000;">&#41;</span> <span style="color: #008000;">&#123;</span>
				j <span style="color: #000080;">=</span> p<span style="color: #008000;">&#91;</span>i<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>
				<span style="color: #0000ff;">while</span> <span style="color: #008000;">&#40;</span>j <span style="color: #000080;">&gt;</span> <span style="color: #0000dd;">0</span> <span style="color: #000040;">&amp;&amp;</span> str<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span> <span style="color: #000040;">!</span><span style="color: #000080;">=</span> str<span style="color: #008000;">&#91;</span>N<span style="color: #000040;">-</span>k<span style="color: #000040;">+</span>j<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span> <span style="color: #666666;">// в этих трех строках немного изменены индексы,   </span>
					j <span style="color: #000080;">=</span> p<span style="color: #008000;">&#91;</span>N<span style="color: #000040;">-</span>k<span style="color: #000040;">+</span>j<span style="color: #000040;">-</span><span style="color: #0000dd;">2</span><span style="color: #008000;">&#93;</span><span style="color: #008080;">;</span>                 <span style="color: #666666;">// в сравнении с обычными при построении префикс-функции, </span>
				<span style="color: #0000ff;">if</span> <span style="color: #008000;">&#40;</span>str<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span> <span style="color: #000080;">==</span> str<span style="color: #008000;">&#91;</span>N<span style="color: #000040;">-</span>k<span style="color: #000040;">-</span><span style="color: #0000dd;">1</span><span style="color: #000040;">+</span>j<span style="color: #008000;">&#93;</span><span style="color: #008000;">&#41;</span>		<span style="color: #666666;">// поскольку учитывается смещение N-k-1</span>
					j<span style="color: #000040;">++</span><span style="color: #008080;">;</span>
				p<span style="color: #008000;">&#91;</span>i<span style="color: #008000;">&#93;</span> <span style="color: #000080;">=</span> j<span style="color: #008080;">;</span>
				<span style="color: #666666;">// при построении префикс-функции сразу находим ее максимальное значение</span>
				<span style="color: #0000ff;">if</span><span style="color: #008000;">&#40;</span>j<span style="color: #000080;">&gt;</span>max<span style="color: #008000;">&#41;</span>
					max<span style="color: #000080;">=</span>j<span style="color: #008080;">;</span>
				i<span style="color: #000040;">++</span><span style="color: #008080;">;</span>
			<span style="color: #008000;">&#125;</span> <span style="color: #666666;">// конец вычисления префикс-функции</span>
			count<span style="color: #000040;">+</span><span style="color: #000080;">=</span>k<span style="color: #000040;">+</span><span style="color: #0000dd;">1</span><span style="color: #000040;">-</span>max<span style="color: #008080;">;</span> <span style="color: #666666;">// для очередной строки находим количество различных подстрок</span>
		<span style="color: #008000;">&#125;</span>
&nbsp;
		<span style="color: #0000dd;">cout</span><span style="color: #000080;">&lt;&lt;</span>count<span style="color: #000080;">&lt;&lt;</span><span style="color: #FF0000;">'<span style="color: #000099; font-weight: bold;">\n</span>'</span><span style="color: #008080;">;</span>
&nbsp;
		<span style="color: #666666;">//system (&quot;pause&quot;);</span>
		<span style="color: #0000ff;">return</span> <span style="color: #0000dd;">0</span><span style="color: #008080;">;</span>
	<span style="color: #008000;">&#125;</span></pre>
							<?php else :
								echo "<p style='color: red;'>Вы не можете просмотреть код программы, пока не было попыток решения этой задачи на сайте acm.timus.ru.</p>";
							endif;
							?>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </td>
    </tr>
</table>
</body>
</html>