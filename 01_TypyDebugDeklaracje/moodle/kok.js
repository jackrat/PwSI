if (document.title === "Kokpit") kokpitSettings();


function kokpitSettings() {
    var me = "JŁ";
    var xolID = "LP986850jiojPIOjpijh";
    var courses = null;
    setTimeout(
        function () {
            var Xol;
            initXol();
            Xol.style.display = "none";
            insertBtns();

            function globalReader() {
                let getCounter = 0;
                console.log("GC:" + getCounter);
                initXol();
                Xol.style.display = "block";
                courses = new Array();
                document.querySelector(".unlist").querySelectorAll("a").forEach(a => {
                    if (a.innerText.includes(me)) {
                        let course = new Object();
                        courses.push(course);
                        course.title = a.getAttribute("title");
                        course.name = a.innerText;
                        course.href = a.href;
                        course.tasks = new Array();
                        let tasksOL = initCourse(course, Xol);
                        getCounter++;
                        console.log("GC:" + getCounter);
                        $.get(a.href,
                            function (data, status) {
                                let parser = new DOMParser();
                                let doc = parser.parseFromString(data, "text/html");
                                doc.querySelectorAll(".instancename").forEach(sp => {
                                    let tsp = sp.querySelector(".accesshide");
                                    if (tsp !== null && tsp.innerText.includes("Zadanie")) {
                                        let alink = sp.closest(".aalink");
                                        if (alink != null) {
                                            let go = !alink.classList.contains("dimmed");
                                            if (!go) {
                                                let awailInf = alink.parentElement.parentElement.querySelector(".availabilityinfo");
                                                go = awailInf !== null && !awailInf.classList.contains("ishidden");
                                            } if (go) {
                                                let task = new Object();
                                                course.tasks.push(task);
                                                task.name = sp.innerText.substr(0, sp.innerText.length - 8);
                                                task.href = alink.href;
                                                task.grades = new Array();
                                                let gradesOL = initTask(task, tasksOL);
                                                fillGradeTable(task, gradesOL);
                                            }
                                        }
                                    }
                                });
                                getCounter--;
                                console.log("GC:" + getCounter);
                            });
                    }
                });
                var wait = setInterval(() => {
                    if (getCounter == 0) {
                        console.log("GC:" + getCounter);
                        clearInterval(wait);
                        coursesReady();
                    }
                }, 100);

                function coursesReady() {
                    Xol.style.backgroundColor = "#fff";
                    disablesy(false);
                }
                function fillGradeTable(task, gradesOL) {
                    getCounter++;
                    console.log("GC:" + getCounter);
                    $.get(task.href + "&action=grading",
                        function (data, status) {
                            let parser = new DOMParser();
                            let doc = parser.parseFromString(data, "text/html");
                            let tab = doc.querySelector(".generaltable");
                            if (tab !== null) {
                                let colnum = tab.querySelector("tr > .c5").innerText.includes("Grupa") ? 6 : 5;
                                tab.querySelectorAll("tr").forEach(tr => {
                                    if (tr.querySelector(".submissionstatussubmitted") !== null && tr.querySelector(".submissiongraded") === null) {
                                        let grade = new Object();
                                        task.grades.push(grade);
                                        grade.who = tr.querySelector(".c2 > a").innerText;
                                        grade.href = tr.querySelector(`.c${colnum} > a`).href;
                                        let late = tr.querySelector(".latesubmission");
                                        grade.late = late !== null ? " - " + late.innerText : "";
                                        initGrade(grade, gradesOL);
                                    }
                                });
                            } getCounter--;
                            console.log("GC:" + getCounter);
                        });
                }
                function initCourse(course, ol) {
                    let li = document.createElement("li");
                    ol.appendChild(li);
                    li.innerHTML = `<a href="${course.href}">${course.title} - ${course.name}</a>`;
                    let tasksOL = document.createElement("ol");
                    li.appendChild(tasksOL);
                    return tasksOL;
                }
                function initTask(task, tasksOL) {
                    let li = document.createElement("li");
                    tasksOL.appendChild(li);
                    li.innerHTML = `<a href="${task.href}">${task.name}</a>`;
                    let gradesOL = document.createElement("ol");
                    li.appendChild(gradesOL);
                    return gradesOL;
                }
                function initGrade(grade, gradesOL) {
                    let li = document.createElement("li");
                    gradesOL.appendChild(li);
                    li.innerHTML = `<a href="${grade.href}">${grade.who}${grade.late}</a>`;
                }
            }
            function insertBtns() {
                let divbtn = document.createElement("div");
                document.body.appendChild(divbtn);
                divbtn.style.position = "absolute";
                divbtn.style.left = "200px";
                divbtn.style.top = "20px";
                divbtn.style.zIndex = 99999;
                let btn1 = document.createElement("button");
                btn1.id = "moodleHelperBtn_001";
                divbtn.appendChild(btn1);
                btn1.innerHTML = "Do oceny...";
                btn1.addEventListener("click", (e) => {
                    disablesy(true);
                    e.preventDefault();
                    globalReader();
                });
                let btn2 = document.createElement("button");
                btn2.id = "moodleHelperBtn_002";
                divbtn.appendChild(btn2);
                btn2.innerHTML = "Ukryj";
                btn2.disabled = true;
                btn2.addEventListener("click", (e) => {
                    e.preventDefault();
                    if (e.currentTarget.innerHTML.includes("Ukryj")) {
                        $("#" + xolID).fadeOut();
                        e.currentTarget.innerHTML = "Pokaż";
                    } else {
                        $("#" + xolID).fadeIn();
                        e.currentTarget.innerHTML = "Ukryj";
                    }
                });
                let btn3 = document.createElement("button");
                btn3.id = "moodleHelperBtn_003";
                btn3.disabled = true;
                divbtn.appendChild(btn3);
                btn3.innerHTML = "Filtruj";
                btn3.addEventListener("click", (e) => {
                    e.preventDefault();
                    if (e.currentTarget.innerHTML === "Filtruj") {
                        showFiltered();
                        e.currentTarget.innerHTML = "Tylko oceny";
                    } else if (e.currentTarget.innerHTML === "Tylko oceny") {
                        showMostFiltered();
                        e.currentTarget.innerHTML = "Nie filtruj";
                    } else if (e.currentTarget.innerHTML === "Nie filtruj") {
                        showUnFiltered();
                        e.currentTarget.innerHTML = "Filtruj";
                    }
                });
            }
            function disablesy(b) {
                document.getElementById(xolID).disabled = b;
                document.getElementById("moodleHelperBtn_001").disabled = b;
                document.getElementById("moodleHelperBtn_002").disabled = b;
                document.getElementById("moodleHelperBtn_003").disabled = b;
            }
            function initXol() {
                Xol = document.getElementById(xolID);
                if (Xol === null) {
                    Xol = document.createElement("ol");
                    Xol.id = xolID;
                    document.body.appendChild(Xol);
                    Xol.style.position = "absolute";
                    Xol.style.display = "block";
                    Xol.style.border = "1px solid blue";
                    Xol.style.paddingTop = "15px";
                    Xol.style.paddingBottom = "15px";
                    Xol.style.right = "40px";
                    Xol.style.top = "80px";
                    Xol.style.bottom = "15px";
                    Xol.style.overflow = "scroll";
                    Xol.style.backgroundColor = "#eee";
                } else {
                    Xol.innerHTML = "";
                    Xol.style.backgroundColor = "#aab";
                }
            }
            function showFiltered() {
                for (let ci = Xol.children.length - 1;
                    ci >= 0;
                    ci--) {
                        let cli = Xol.children[ci];
                    let tol = cli.querySelector("ol");
                    for (let ti = tol.children.length - 1;
                        ti >= 0;
                        ti--) {
                            let tli = tol.children[ti];
                        let gol = tli.querySelector("ol");
                        if (gol.children.length === 0) tli.remove();
                    } if (tol.children.length === 0) cli.remove();
                }
            }
            function showUnFiltered() {
                Xol.innerHTML = "";
                courses.forEach(course => {
                    let cli = document.createElement("li");
                    Xol.appendChild(cli);
                    cli.innerHTML = `<a href="${course.href}">${course.title} - ${course.name}</a>`;
                    let tol = document.createElement("ol");
                    cli.appendChild(tol);
                    course.tasks.forEach(task => {
                        let tli = document.createElement("li");
                        tol.appendChild(tli);
                        tli.innerHTML = `<a href="${task.href}">${task.name}</a>`;
                        let gol = document.createElement("ol");
                        tli.appendChild(gol);
                        task.grades.forEach(grade => {
                            let gli = document.createElement("li");
                            gol.appendChild(gli);
                            gli.innerHTML = `<a href="${grade.href}">${grade.who}${grade.late}</a>`;
                        });
                    });
                });
            }
            function showMostFiltered() {
                Xol.innerHTML = "";
                courses.forEach(course => {
                    course.tasks.forEach(task => {
                        task.grades.forEach(grade => {
                            let gli = document.createElement("li");
                            Xol.appendChild(gli);
                            gli.innerHTML = `<a href="${grade.href}">${grade.who}${grade.late}</a>`;
                        });
                    });
                });
            }
        }, 500);
}