<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css" />
    <title>Schedule</title>
</head>
<body>
    <nav class="navbar">
        <div id="start" class="logo">
            <a id="logo">Schedule</a>
            <!-- <img src="{% static 'stream/logo.png'%}" style="width: 25px;" alt="logo"> -->
        </div>
        <div id="center">
            <div class="searchbar">
                <input type="text" size="35" placeholder="Search">
            </div>
            <button class="searchbutton">
                <a class="seachwritten">Search</a>
                <!-- <img src="{% static 'stream/search.png'%}" alt="" class="searchicon"> -->
            </button>
        </div>
        <div class="notificationsAccount">
            <button id="notification" class="notification">
                <!-- <img src="{% static 'stream/notification.png'%}" style="width: 25px;" alt=""> -->
            </button>
            <button class="account">
                <!-- <img class="account-icon" src="{% static 'stream/account.png'%}" style="width: 25px;" alt="sg"> -->
                <a class="accountText">SIGN IN</a>
            </button>
        </div>
    </nav>
    <?php
    class MyDB extends SQLite3 {
        function __construct() {
            $this->open('timeTable.sqlite3');
        }
    }
    $db = new MyDB();

    $sql = "SELECT rowid,* FROM courses";
    $courses = $db->query($sql);
    $semNumbers = array();
    while($row = $courses->fetchArray()){
        if(!(in_array($row['sem_no'], $semNumbers))){
            array_push($semNumbers, $row['sem_no']);
        }
    }
    asort($semNumbers);
    $sql = "SELECT rowid,* FROM meetLinks";
    $meetLinks = $db->query($sql);
    // while($row = $meetLinks->fetchArray()){
    //     echo "{$row['day']} \t {$row['atTime']} \t {$row['meet_link']} \t {$row['course_id']} <br/>";
    // }
    ?>

    <div class="outer">
        <div class="sems">
            <?php 
            global $semNumbers;
            foreach($semNumbers as $sem){
                echo "<form method=\"post\"><input type=\"submit\" name=\"button1\" class=\"semNumbers\" value=\"{$sem}\" /></form>";
            }?>
        </div>
        <div class="courseslist">
            <?php
            $semnum = 4;
            if(array_key_exists('button1', $_POST)) {
                $semnum = $_POST['button1'];
            }
            while($row = $courses->fetchArray()){
                if($row['sem_no'] == $semnum){
                    echo "<form method=\"post\"><h3><input type=\"submit\" name=\"button2\" class=\"courses\" value=\"{$row['course_code']}\"/></h3></form>";
                }
            }
            ?>
        </div>
        <div class="linksAndTasks">
            <div class="CourseTasks">
                <h3 class="heading">Course Tasks</h3>
                <div class="taskList">
                    <h4 class="Tasks">Tasks</h4>
                    <h4 class="Tasks">Tasks</h4>
                </div>
            </div>
            <div class="meetlinks">
                <h3 class="heading">Course Meet Links</h3>
                <div class="meetlinkList">
                    <?php
                    $course = "24";
                    if(array_key_exists('button2', $_POST)) {
                        $course = $_POST['button2'];
                        while($row = $courses->fetchArray()){
                            if($row['course_code'] == $course){
                                $course = $row['rowid'];
                            }
                        }
                    }
                    $listdays = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
                    while($row = $meetLinks->fetchArray()){
                        if($row['course_id'] == $course){
                            echo "<a class=\"links conr\" href={$row['meet_link']} target=\"_blank\" style=\"text-decoration: none\">{$listdays[$row['day']-1]}&emsp;{$row['atTime']}</a>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="stream">
            <div class="description">
                <br>
                <?php
                $course = "CS2200";
                if(array_key_exists('button2', $_POST)) {
                    $course = $_POST['button2'];
                }
                while($row = $courses->fetchArray()){
                    if($row['course_code'] == $course){
                        echo "<h2 style=\"color: rgb(202, 56, 56);\">{$row['course_name']}</h2>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="linksAndTasks">
            <div class="meetlinks">

                <h3 class="heading">Meet Links for Today</h3>
                <div class="meetlinkList">
                    <?php
                        $t=date('d-m-Y');
                        $day = date("D",strtotime($t));
                        $listdays = array("Mon", "Tue", "Wed", "Thu", "Fri");
                        while($row = $meetLinks->fetchArray()){
                            if($listdays[$row['day']-1] == $day){
                                echo "<a class=\"links today\" href={$row['meet_link']} target=\"_blank\" style=\"text-decoration: none\">{$listdays[$row['day']-1]}&emsp;{$row['atTime']}</a>";
                            }
                        }
                    ?>
                </div>
                <script>
                    var listdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
                    var list = document.getElementsByClassName("today");
                    // console.log(list)
                    for(var i=0;i<list.length;i++){
                        time = list[i].innerHTML.split(" ");
                        day = time[0];
                        list[i].innerHTML = time[1].split(".")[0] + ':' + time[1].split(".")[1].substr(1,2) + '     ' + time[0];
                    }
                </script>
            </div>
            <div class="selectShow">
                <div class="displayButtons">Today</div>
                <div class="displayButtons">week</div>
                <div class="displayButtons">cal</div>
            </div>
            <div class="CourseTasks">
                <div class="taskList" id='todayList'>
                    <h4 class="Tasks">Tasks</h4>
                    <h4 class="Tasks">Tasks</h4>
                </div>
                <!-- <div class="taskList" id='weekList'>
                    <h4 class="Tasks">Tasks</h4>
                    <h4 class="Tasks">Tasks</h4>
                </div> -->
                <div class="calender">

                </div>
            </div>
        </div>
        <!-- <div class="chatSelfStream">
            <div class="chat">
            </div>
        </div> -->
    </div>
</body>
</html>
