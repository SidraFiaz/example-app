<!DOCTYPE html>
<html>
<head>
<title>{{ \App\Support\BrowserTitle::make('School Leaving Certificate') }}</title>

<style>

body{
    font-family: "Times New Roman", serif;
    background:white;
}

.page{
    width:800px;
    min-height:1100px;
    margin:auto;
    padding:50px;
    box-sizing:border-box;
}


.top-info{
    display:flex;
    justify-content:space-between;
    font-size:14px;
    margin-bottom:40px;
}


.school{
    text-align:center;
}


.school h1{
    font-size:28px;
    margin:0;
    font-weight:bold;
}


.school p{
    margin:5px;
    font-size:16px;
}


.title{
    text-align:center;
    color:green;
    font-size:22px;
    margin-top:35px;
    font-weight:bold;
}


.content{
    margin-top:50px;
    font-size:18px;
    line-height:3;
}


.blank{
    display:inline-block;
    border-bottom:1px solid black;
    min-width:300px;
}


.footer{
    margin-top:120px;
    display:flex;
    justify-content:space-between;
    font-weight:bold;
}


.print{
    margin:20px;
}


@media print{

.print{
display:none;
}

.page{
margin:0;
}

}

</style>

</head>


<body>


<button class="print" onclick="window.print()">
Print
</button>



<div class="page">



<div class="top-info">

<div>
Serial No: ____________
</div>


<div>
Registration No: ____________
</div>


<div>
Student No: ____________
</div>

</div>




<div class="school">


<h1>
King Way Science High School
</h1>


<p>
Affiliated with BISE LAHORE
</p>


</div>




<div class="title">

SCHOOL LEAVING CERTIFICATE

</div>





<div class="content">


This is Certify that

<br>


Mr/Miss

<span class="blank">
{{ $admission->student_name }}
</span>


<br>


S/O D/O

<span class="blank">
{{ $admission->father_name }}
</span>


has been a student of this institution.


<br>


From

<span class="blank">
{{ $admission->admission_date }}
</span>


to

<span class="blank">
____________</span>



<br>


He/She has passed his/her exams of class

<span class="blank">
{{ $admission->studentClass->class_name ?? '' }}
</span>



<br>


Presently he/she is studying in class

<span class="blank">
{{ $admission->studentClass->class_name ?? '' }}
</span>


<br>


According to the information provided by the student his/her date of birth is


<br>


<span class="blank">
{{ $admission->date_of_birth }}
</span>



</div>





<div class="footer">


<div>

Date: ____________

</div>



<div style="text-align:center">

PRINCIPLE

<br><br>

ADDRESS: ____________

</div>



</div>



</div>


</body>
</html>