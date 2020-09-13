<?php
   include('session.php');
   //reading csv file and save it into json object
   $csv_array = Array();
   $file = fopen($_FILES['file']['tmp_name'], 'r');
   if($file){
       while (($line = fgetcsv($file)) !== FALSE) {
        $temp = array( 
            'studentid'=>"$line[0]", 
            'quiz'=>"$line[1]",
            'midterm'=>"$line[2]", 
            'final'=>"$line[3]"
            );
        array_push($csv_array,$temp);
        
       }
       $obj= json_encode($csv_array);
      
       fclose($file);
   }

?>



<html>
   
   <head>
      <title>Grade</title>
   </head>
   <body>
   
   <div class="slidecontainer" align='center'>
    <h3 align='center'>Cut off range</h3>
    <input id="aplusslider" type="range" value="95" step="1" min="0" max="100" class="slider">
    <span>A+:</span>
    <output class="aplusslider">95</output>
    
    <input id="aslider" type="range" value="90" step="1" min="0" max="100" class="slider">
    <span>A:</span>
    <output class="aslider">90</output>
    
    <input id="aminusslider" type="range" value="85" step="1" min="0" max="100" class="slider">
    <span>A-:</span>
    <output class="aminusslider">85</output>
    <br>
    <input id="bplusslider" type="range" value="80" step="1" min="0" max="100" class="slider">
    <span>B+:</span>
    <output class="bplusslider">80</output>
    
    <input id="bslider" type="range" value="75" step="1" min="0" max="100" class="slider">
    <span>B:</span>
    <output class="bslider">75</output>
   
    <input id="bminusslider" type="range" value="70" step="1" min="0" max="100" class="slider">
    <span>B-:</span>
    <output class="bminusslider">70</output>
    <br>
    <input id="cplusslider" type="range" value="65" step="1" min="0" max="100" class="slider">
    <span>C+:</span>
    <output class="cplusslider">65</output>
   
    <input id="cslider" type="range" value="60" step="1" min="0" max="100" class="slider" >
    <span>C:</span>
    <output class="cslider">60</output>
    
    <input id="cminusslider" type="range" value="55" step="1" min="0" max="100" class="slider">
    <span>C-:</span>
    <output class="cminusslider">55</output>
    <br>
    <input id="dslider" type="range" value="50" step="1" min="0" max="100" class="slider">
    <span>D:</span>
    <output class="dslider">50</output>
   
    <input id="fslider" type="range" value="45" step="1" min="0" max="100" class="slider" hidden>
    <span hidden>F:</span>
    <output class="fslider" hidden>45</output>
    
    </div>


   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   <h3 align='center'>Class Marks</h3>
   <table align='center' id="table_marks">
        <thead></thead>
        <tbody></tbody>
    </table>

    <h3 align='center'>Class Grades</h3>
    <table align='center' id="table_grades">
        <thead></thead>
        <tbody></tbody>
    </table>
   
   
   <h3 align='center'>Histogram</h3>
    <div id='grade' style="margin-left:25%">
        
        <h3 id='aplus'>A+ </h3>
        <h3 id='a'>A </h3>
        <h3 id='aminus'>A- </h3>
        <h3 id='bplus'>B+ </h3>
        <h3 id='b'>B </h3>
        <h3 id='bminus'>B- </h3>
        <h3 id='cplus'>C+ </h3>
        <h3 id='c'>C </h3>
        <h3 id='cminus'>C- </h3>
        <h3 id='d'>D </h3>
        <h3 id='f'>F </h3>
        
    </div>
    <p align='center'><a href = "main.php">Go back</a></p>
   <p align='center'><a href = "logout.php">Sign Out</a></p>

   </body>
   
</html>



<script type="text/javascript">
//list initial
var gradelist = [];
var gradeindex=0;

$(document).on('input', 'input[type="range"]', function(e) {
    document.querySelector('output.'+this.id).innerHTML = e.target.value;
});


sliders = document.querySelectorAll('[type="range"]');
tables = document.querySelectorAll('[id="table_grades"]');
for(var i=0, l=sliders.length; i < l; i++){
    sliders[i].addEventListener('change', sliderupdate)
    sliders[i].addEventListener('change', marksupdate)
}



sliderupdate();

function sliderupdate(){
    cutoffarray = [];
    for(var i=0; i<sliders.length; i++){
        cutoffarray.push({
            slider: sliders[i].id,
            value: sliders[i].value
        });
    }
    console.log(cutoffarray);
}



//parsing json object from php
var phpobj = <?php echo json_encode($obj) ?>;
var JSONString = $.parseJSON(phpobj);

//document.getElementById("testing").innerHTML = JSONGradeString['a'];

//saving the total of marks
for (i = 0; i < JSONString.length; i++) {
    if (JSONString[i]["studentid"]=="total"){
        var totalindex = i;
        //console.log(totalindex);
    }
}

//return back to main page for total not =100
var quiztotal = parseFloat(JSONString[totalindex]["quiz"]);
var midtermtotal = parseFloat(JSONString[totalindex]["midterm"]);
var finaltotal = parseFloat(JSONString[totalindex]["final"]);
if((quiztotal+midtermtotal+finaltotal)!=100){
    alert("Please upload another file with total grade of 100");
    window.location.href = "main.php";
}


//create table marks
var marks_table='';
var grades_table='';

//loop for all strings
for (i = 0; i < JSONString.length; i++) {
        //creating mark table variable
        var marks_cells = '<tr>'+'<td>'+JSONString[i]["studentid"]+'</td>'+'<td>'+JSONString[i]["quiz"]+'</td>'+
                        '<td>'+JSONString[i]["midterm"]+'</td>'+'<td>'+JSONString[i]["final"]+'</td>'+'</tr>';
        marks_table = marks_table+marks_cells;
}
//set table on html
document.getElementById("table_marks").innerHTML = marks_table;


//create class grades initial table
for (i = 0; i < JSONString.length; i++) {
        if(JSONString[i]["studentid"]!="studentID" && JSONString[i]["studentid"]!="total" && i>=1 && i<= JSONString.length-1 && JSONString[i]["studentid"]!=""){
            var quiz = parseFloat(JSONString[i]["quiz"]);
            var midterm = parseFloat(JSONString[i]["midterm"]);
            var final = parseFloat(JSONString[i]["final"]);
            var percentage = Math.round((quiz/100*quiztotal)+(midterm/100*midtermtotal)+(final/100*finaltotal));
            gradelist.push({
                studentid: JSONString[i]["studentid"],
                percentage: percentage,
                grade:"undefined"
            });
        }
}
console.log(gradelist);

//insert table cells to a var
for (i = 0; i < gradelist.length; i++)  {
        var grades_cells = '<tr>'+'<td>'+gradelist[i]["studentid"]+'</td>'+'<td>'+gradelist[i]["percentage"]+'</td>'+
                        '<td>'+gradelist[i]["grade"]+'</td>'+'</tr>';
        grades_table = grades_table+grades_cells;
}
//set table
document.getElementById("table_grades").innerHTML = grades_table;

//update class grades
marksupdate();
function marksupdate(){
    var new_grades_table ='<tr><th>StudentID</th><th>Percentage</th><th>Grade</th></tr>';
    //remove all child
    while (document.getElementById('aplus').childNodes.length > 1) {
        document.getElementById('aplus').removeChild(document.getElementById('aplus').lastChild);
    }
    while (document.getElementById('a').childNodes.length > 1) {
        document.getElementById('a').removeChild(document.getElementById('a').lastChild);
    }
    while (document.getElementById('aminus').childNodes.length > 1) {
        document.getElementById('aminus').removeChild(document.getElementById('aminus').lastChild);
    }
    while (document.getElementById('bplus').childNodes.length > 1) {
        document.getElementById('bplus').removeChild(document.getElementById('bplus').lastChild);
    }
    while (document.getElementById('b').childNodes.length > 1) {
        document.getElementById('b').removeChild(document.getElementById('b').lastChild);
    }
    while (document.getElementById('bminus').childNodes.length > 1) {
        document.getElementById('bminus').removeChild(document.getElementById('bminus').lastChild);
    }
    while (document.getElementById('cplus').childNodes.length > 1) {
        document.getElementById('cplus').removeChild(document.getElementById('cplus').lastChild);
    }
    while (document.getElementById('c').childNodes.length > 1) {
        document.getElementById('c').removeChild(document.getElementById('c').lastChild);
    }
    while (document.getElementById('cminus').childNodes.length > 1) {
        document.getElementById('cminus').removeChild(document.getElementById('cminus').lastChild);
    }
    while (document.getElementById('d').childNodes.length > 1) {
        document.getElementById('d').removeChild(document.getElementById('d').lastChild);
    }
    while (document.getElementById('f').childNodes.length > 1) {
        document.getElementById('f').removeChild(document.getElementById('f').lastChild);
    }
    
    for (i = 0; i < gradelist.length; i++) {
        //a dot child
        var newSpan = document.createElement('span');
        newSpan.setAttribute('class', 'dot');
        //If the percentage calculated is under the cut off then a dot will be added to the html element
        if(gradelist[i]["percentage"]>=cutoffarray[0]["value"]&&gradelist[i]["percentage"]<=100){
            gradelist[i]["grade"]="A+";
            document.getElementById('aplus').appendChild(newSpan);
        }
        else if(gradelist[i]["percentage"]>=cutoffarray[1]["value"]&&gradelist[i]["percentage"]<cutoffarray[0]["value"]){
            gradelist[i]["grade"]="A";
            document.getElementById('a').appendChild(newSpan);
        }
        else if(gradelist[i]["percentage"]>=cutoffarray[2]["value"]&&gradelist[i]["percentage"]<cutoffarray[1]["value"]){
            gradelist[i]["grade"]="A-";
            document.getElementById('aminus').appendChild(newSpan);
        }
        else if(gradelist[i]["percentage"]>=cutoffarray[3]["value"]&&gradelist[i]["percentage"]<cutoffarray[2]["value"]){
            gradelist[i]["grade"]="B+";
            document.getElementById('bplus').appendChild(newSpan);
        }
        else if(gradelist[i]["percentage"]>=cutoffarray[4]["value"]&&gradelist[i]["percentage"]<cutoffarray[3]["value"]){
            gradelist[i]["grade"]="B";
            document.getElementById('b').appendChild(newSpan);
        }
        else if(gradelist[i]["percentage"]>=cutoffarray[5]["value"]&&gradelist[i]["percentage"]<cutoffarray[4]["value"]){
            gradelist[i]["grade"]="B-";
            document.getElementById('bminus').appendChild(newSpan);
        }
        else if(gradelist[i]["percentage"]>=cutoffarray[6]["value"]&&gradelist[i]["percentage"]<cutoffarray[5]["value"]){
            gradelist[i]["grade"]="C+";
            document.getElementById('cplus').appendChild(newSpan);
        }
        else if(gradelist[i]["percentage"]>=cutoffarray[7]["value"]&&gradelist[i]["percentage"]<cutoffarray[6]["value"]){
            gradelist[i]["grade"]="C";
            document.getElementById('c').appendChild(newSpan);
        }
        else if(gradelist[i]["percentage"]>=cutoffarray[8]["value"]&&gradelist[i]["percentage"]<cutoffarray[7]["value"]){
            gradelist[i]["grade"]="C-";
            document.getElementById('cminus').appendChild(newSpan);
        }
        else if(gradelist[i]["percentage"]>=cutoffarray[9]["value"]&&gradelist[i]["percentage"]<cutoffarray[8]["value"]){
            gradelist[i]["grade"]="D";
            document.getElementById('d').appendChild(newSpan);
        }
        else {
            gradelist[i]["grade"]="F";
            document.getElementById('f').appendChild(newSpan);
        }
        
        //set table cells
        var grades_cells = '<tr>'+'<td>'+gradelist[i]["studentid"]+'</td>'+'<td>'+gradelist[i]["percentage"]+'</td>'+
                        '<td>'+gradelist[i]["grade"]+'</td>'+'</tr>';
        new_grades_table = new_grades_table+grades_cells;
       // console.log(new_grades_table);
            
    }
    document.getElementById("table_grades").innerHTML = new_grades_table;
}
</script>


<style>
.dot {
  height: 15px;
  width: 15px;
  background-color: #000000;
  border-radius: 50%;
  display: inline-block;
  margin: 1px;
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 25px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  background: Black;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  background: Black;
  cursor: pointer;
}
</style>

