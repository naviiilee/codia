<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C Programming Course</title>
    <link rel="stylesheet" href="{{ asset('html.css') }}">
</head>

<body>

    <div class="sidebar">
        <h2>C0DiA</h2>
        <a href="{{ route('dashboard') }}">🏠 Home</a>
        <a href="{{ route('profile') }}">👤 Profile</a>
        <a href="{{ route('course') }}">📚 Courses</a>
        <a href="{{ route('certificate.show') }}">🏆 Certificates</a>
        <a href="{{ route('logout') }}">🚪 Logout</a>
    </div>

    <div class="main">

        @if (session('passed') !== null)
            <div class="result-box" style="
                padding:20px;
                margin-bottom:20px;
                border-radius:10px;
                background: {{ session('passed') ? '#d4edda' : '#f8d7da' }};
                color: {{ session('passed') ? '#155724' : '#721c24' }};
            ">
                <h2>{{ session('passed') ? '🎉 Congratulations, You Passed!' : '❌ You Failed!' }}</h2>
                <p>Score: {{ session('score') }}/{{ session('total', 10) }}</p>
                <p>Percentage: {{ session('percentage') }}%</p>

                @if (session('passed'))
                    @php
                        $nextRoute = match(session('quiz')) {
                            'c_lesson1' => route('c.course') . '#lesson2',
                            'c_lesson2' => route('c.course') . '#lesson3',
                            'c_lesson3' => route('c.course') . '#lesson4',
                            'c_lesson4' => route('c.course') . '#lesson5',
                            'c_lesson5' => route('c.course') . '#final',
                            'c_final'   => route('dashboard'),
                            default     => route('c.course'),
                        };
                        $nextLabel = session('quiz') === 'c_final' ? 'Back to Dashboard' : 'Proceed to Next Lesson →';
                    @endphp
                    <a href="{{ $nextRoute }}">
                        <button type="button">{{ $nextLabel }}</button>
                    </a>
                @else
                    @php
                        $retakeRoute = match(session('quiz')) {
                            'c_lesson1' => route('c.quiz'),
                            'c_lesson2' => route('c.lesson2.quiz'),
                            'c_lesson3' => route('c.lesson3.quiz'),
                            'c_lesson4' => route('c.lesson4.quiz'),
                            'c_lesson5' => route('c.lesson5.quiz'),
                            'c_final'   => route('c.final.exam'),
                            default     => route('c.quiz'),
                        };
                    @endphp
                    <form method="GET" action="{{ $retakeRoute }}">
                        <button type="submit">Retake Quiz</button>
                    </form>
                @endif
            </div>
        @endif

        @if (isset($certificate) && !empty($certificate))
            <div style="margin-bottom:20px;">
                <a href="{{ route('certificate.show') }}">
                    <button type="button">View C Certificate</button>
                </a>
            </div>
        @endif

        <div class="lesson-box">

            {{-- ============================================================ --}}
            {{-- LESSON CONTENT                                               --}}
            {{-- ============================================================ --}}
            @if (!$showQuiz)

                {{-- ── LESSON 1 ── --}}
                <h2>Lesson 1: Introduction to C Programming</h2>

                <p><b>C</b> is a general-purpose programming language created by Dennis Ritchie in 1972. It is one of the most widely used languages and is the foundation of many modern languages like C++, Java, and Python.</p>

                <h3>Why Learn C?</h3>
                <ul>
                    <li>Fast and efficient — close to hardware</li>
                    <li>Foundation of modern programming languages</li>
                    <li>Used in operating systems, embedded systems, and games</li>
                    <li>Teaches memory management and low-level thinking</li>
                </ul>

                <h3>Basic Structure of a C Program:</h3>
                <pre>
#include &lt;stdio.h&gt;

int main() {
    printf("Hello, World!\n");
    return 0;
}
</pre>

                <h3>Explanation of Each Line:</h3>
                <pre>
#include &lt;stdio.h&gt;
This is a preprocessor directive.
It includes the Standard Input Output library so we can use printf and scanf.

int main()
This is the main function — where the program starts running.
"int" means the function returns an integer.

{
Opening curly brace — starts the function body.

    printf("Hello, World!\n");
Prints text to the screen.
"\n" moves the cursor to the next line.

    return 0;
Returns 0 to the operating system, meaning the program ended successfully.

}
Closing curly brace — ends the function body.
</pre>

                <h3>Important Notes:</h3>
                <ul>
                    <li>Every C program must have a <code>main()</code> function.</li>
                    <li>Statements end with a semicolon <code>;</code></li>
                    <li><code>#include &lt;stdio.h&gt;</code> is needed for input/output functions.</li>
                    <li>C is case-sensitive — <code>Main</code> and <code>main</code> are different.</li>
                    <li>Use <code>//</code> for single-line comments and <code>/* */</code> for multi-line comments.</li>
                </ul>

                <h2>Lesson 1.1: Comments and Basic Output</h2>

                <h3>Comments:</h3>
                <pre>
// This is a single-line comment

/* This is a
   multi-line comment */
</pre>

                <h3>printf() — Printing Output:</h3>
                <pre>
#include &lt;stdio.h&gt;

int main() {
    printf("Hello!\n");
    printf("Welcome to C Programming.\n");
    printf("This is line 3.\n");
    return 0;
}
</pre>

                <h3>Output:</h3>
                <pre>
Hello!
Welcome to C Programming.
This is line 3.
</pre>

                <h3>Escape Sequences:</h3>
                <pre>
\n   → New line
\t   → Tab space
\\   → Backslash
\"   → Double quote
</pre>

                <form method="GET" action="{{ route('c.quiz') }}">
                    <button>Quiz Lesson 1</button>
                </form>

                {{-- Lesson 2 --}}
                @if ($current_lesson < 2)
                    <hr><h2>Lesson 2 🔒</h2>
                    <p style="color:gray;">Complete Lesson 1 Quiz to unlock this lesson.</p>
                @endif

                @if ($current_lesson >= 2)
                    <hr>
                    <h2 id="lesson2">Lesson 2: Data Types, Variables, printf and scanf</h2>

                    <p>Variables are containers for storing data. In C, every variable must have a declared data type before it can be used.</p>

                    <h3>Common Data Types:</h3>
                    <pre>
int     → whole numbers          (e.g. 5, -3, 100)
float   → decimal numbers        (e.g. 3.14, -0.5)
double  → larger decimals        (e.g. 3.14159265)
char    → single character       (e.g. 'A', 'z')
</pre>

                    <h3>Declaring Variables:</h3>
                    <pre>
int age = 20;
float price = 99.99;
char grade = 'A';
double pi = 3.14159265;
</pre>

                    <h3>printf() — Printing Variables:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int age = 20;
    float price = 99.99;
    char grade = 'A';

    printf("Age: %d\n", age);
    printf("Price: %.2f\n", price);
    printf("Grade: %c\n", grade);

    return 0;
}
</pre>

                    <h3>Format Specifiers:</h3>
                    <pre>
%d   → integer (int)
%f   → float / double
%.2f → float with 2 decimal places
%c   → character (char)
%s   → string
</pre>

                    <h3>scanf() — Reading Input:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int age;
    printf("Enter your age: ");
    scanf("%d", &amp;age);
    printf("You are %d years old.\n", age);
    return 0;
}
</pre>

                    <h3>Explanation of scanf:</h3>
                    <pre>
scanf("%d", &amp;age);

"%d"  → format specifier (expects an integer)
&amp;age  → address of the variable (where to store the input)
      → The "&amp;" is the "address-of" operator — required for scanf!
</pre>

                    <h3>Full Example — Multiple Inputs:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    char name[50];
    int age;
    float gpa;

    printf("Enter name: ");
    scanf("%s", name);

    printf("Enter age: ");
    scanf("%d", &amp;age);

    printf("Enter GPA: ");
    scanf("%f", &amp;gpa);

    printf("\nName: %s\n", name);
    printf("Age: %d\n", age);
    printf("GPA: %.2f\n", gpa);

    return 0;
}
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Always declare a variable's type before using it.</li>
                        <li>Use the correct format specifier in printf/scanf.</li>
                        <li>Always use <code>&amp;</code> in scanf (except for strings/arrays).</li>
                        <li>Variable names cannot start with a number.</li>
                        <li>C is case-sensitive: <code>Age</code> and <code>age</code> are different variables.</li>
                    </ul>

                    <form method="GET" action="{{ route('c.lesson2.quiz') }}">
                        <button>Quiz Lesson 2</button>
                    </form>
                @endif

                {{-- Lesson 3 --}}
                @if ($current_lesson < 3)
                    <hr><h2>Lesson 3 🔒</h2>
                    <p style="color:gray;">Complete Lesson 2 Quiz to unlock this lesson.</p>
                @endif

                @if ($current_lesson >= 3)
                    <hr>
                    <h2 id="lesson3">Lesson 3: If-Else Statements</h2>

                    <p>If-else statements are used to make decisions in a program. The code inside the <code>if</code> block runs only when the condition is true.</p>

                    <h3>Basic Syntax:</h3>
                    <pre>
if (condition) {
    // runs if condition is TRUE
} else {
    // runs if condition is FALSE
}
</pre>

                    <h3>Example — Pass or Fail:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int score;
    printf("Enter your score: ");
    scanf("%d", &amp;score);

    if (score >= 75) {
        printf("You PASSED!\n");
    } else {
        printf("You FAILED!\n");
    }

    return 0;
}
</pre>

                    <h3>else if — Multiple Conditions:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int score;
    printf("Enter score: ");
    scanf("%d", &amp;score);

    if (score >= 90) {
        printf("Grade: A\n");
    } else if (score >= 80) {
        printf("Grade: B\n");
    } else if (score >= 70) {
        printf("Grade: C\n");
    } else if (score >= 60) {
        printf("Grade: D\n");
    } else {
        printf("Grade: F\n");
    }

    return 0;
}
</pre>

                    <h3>Comparison Operators:</h3>
                    <pre>
==   → equal to
!=   → not equal to
&gt;    → greater than
&lt;    → less than
&gt;=   → greater than or equal
&lt;=   → less than or equal
</pre>

                    <h3>Logical Operators:</h3>
                    <pre>
&amp;&amp;   → AND  (both must be true)
||   → OR   (at least one must be true)
!    → NOT  (reverses the condition)
</pre>

                    <h3>Example — Logical Operators:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int age;
    printf("Enter age: ");
    scanf("%d", &amp;age);

    if (age >= 18 &amp;&amp; age &lt;= 65) {
        printf("You are of working age.\n");
    } else {
        printf("Outside working age range.\n");
    }

    return 0;
}
</pre>

                    <h3>Nested If-Else:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int num;
    printf("Enter a number: ");
    scanf("%d", &amp;num);

    if (num > 0) {
        if (num % 2 == 0) {
            printf("Positive and Even\n");
        } else {
            printf("Positive and Odd\n");
        }
    } else if (num &lt; 0) {
        printf("Negative number\n");
    } else {
        printf("Zero\n");
    }

    return 0;
}
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Use <code>==</code> for comparison, NOT <code>=</code> (assignment).</li>
                        <li>Curly braces <code>{}</code> are optional for single statements but always recommended.</li>
                        <li>Conditions must be inside parentheses <code>()</code>.</li>
                        <li>else if can be chained as many times as needed.</li>
                    </ul>

                    <form method="GET" action="{{ route('c.lesson3.quiz') }}">
                        <button>Quiz Lesson 3</button>
                    </form>
                @endif

                {{-- Lesson 4 --}}
                @if ($current_lesson < 4)
                    <hr><h2>Lesson 4 🔒</h2>
                    <p style="color:gray;">Complete Lesson 3 Quiz to unlock this lesson.</p>
                @endif

                @if ($current_lesson >= 4)
                    <hr>
                    <h2 id="lesson4">Lesson 4: Loops in C</h2>

                    <p>Loops are used to repeat a block of code multiple times. C has three types of loops: <b>for</b>, <b>while</b>, and <b>do-while</b>.</p>

                    <h2>Lesson 4.1: For Loop</h2>
                    <pre>
for (initialization; condition; update) {
    // code to repeat
}
</pre>

                    <h3>Example:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    for (int i = 1; i &lt;= 5; i++) {
        printf("%d\n", i);
    }
    return 0;
}
</pre>

                    <h3>Output:</h3>
                    <pre>
1
2
3
4
5
</pre>

                    <h2>Lesson 4.2: While Loop</h2>
                    <pre>
while (condition) {
    // code to repeat
}
</pre>

                    <h3>Example:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int i = 1;
    while (i &lt;= 5) {
        printf("%d\n", i);
        i++;
    }
    return 0;
}
</pre>

                    <h2>Lesson 4.3: Do-While Loop</h2>
                    <pre>
do {
    // code runs at least once
} while (condition);
</pre>

                    <h3>Example:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int i = 1;
    do {
        printf("%d\n", i);
        i++;
    } while (i &lt;= 5);
    return 0;
}
</pre>

                    <h3>Difference Between Loops:</h3>
                    <pre>
for loop     → used when number of iterations is known
while loop   → used when iterations depend on a condition
do-while     → always runs at least once before checking condition
</pre>

                    <h2>Lesson 4.4: Star Patterns using Loops</h2>

                    <h3>Pattern 1 — Right Triangle:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int n = 5;
    for (int i = 1; i &lt;= n; i++) {
        for (int j = 1; j &lt;= i; j++) {
            printf("* ");
        }
        printf("\n");
    }
    return 0;
}
</pre>
                    <h3>Output:</h3>
                    <pre>
*
* *
* * *
* * * *
* * * * *
</pre>

                    <h3>Pattern 2 — Inverted Triangle:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int n = 5;
    for (int i = n; i >= 1; i--) {
        for (int j = 1; j &lt;= i; j++) {
            printf("* ");
        }
        printf("\n");
    }
    return 0;
}
</pre>
                    <h3>Output:</h3>
                    <pre>
* * * * *
* * * *
* * *
* *
*
</pre>

                    <h3>Pattern 3 — Pyramid:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int n = 5;
    for (int i = 1; i &lt;= n; i++) {
        // print spaces
        for (int j = i; j &lt; n; j++) {
            printf(" ");
        }
        // print stars
        for (int k = 1; k &lt;= (2 * i - 1); k++) {
            printf("*");
        }
        printf("\n");
    }
    return 0;
}
</pre>
                    <h3>Output:</h3>
                    <pre>
    *
   ***
  *****
 *******
*********
</pre>

                    <h3>Pattern 4 — Square:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int n = 4;
    for (int i = 1; i &lt;= n; i++) {
        for (int j = 1; j &lt;= n; j++) {
            printf("* ");
        }
        printf("\n");
    }
    return 0;
}
</pre>
                    <h3>Output:</h3>
                    <pre>
* * * *
* * * *
* * * *
* * * *
</pre>

                    <h3>Loop Control Statements:</h3>
                    <pre>
break;    → exits the loop immediately
continue; → skips current iteration and goes to next
</pre>

                    <h3>Break Example:</h3>
                    <pre>
for (int i = 1; i &lt;= 10; i++) {
    if (i == 5) break;
    printf("%d\n", i);
}
// Prints 1 2 3 4 then stops
</pre>

                    <h3>Continue Example:</h3>
                    <pre>
for (int i = 1; i &lt;= 5; i++) {
    if (i == 3) continue;
    printf("%d\n", i);
}
// Prints 1 2 4 5 (skips 3)
</pre>

                    <form method="GET" action="{{ route('c.lesson4.quiz') }}">
                        <button>Quiz Lesson 4</button>
                    </form>
                @endif

                {{-- Lesson 5 --}}
                @if ($current_lesson < 5)
                    <hr><h2>Lesson 5 🔒</h2>
                    <p style="color:gray;">Complete Lesson 4 Quiz to unlock this lesson.</p>
                @endif

                @if ($current_lesson >= 5)
                    <hr>
                    <h2 id="lesson5">Lesson 5: Switch Case</h2>

                    <p>The <b>switch</b> statement is used to select one of many code blocks to execute. It is an alternative to long if-else if chains when comparing the same variable to multiple values.</p>

                    <h3>Basic Syntax:</h3>
                    <pre>
switch (expression) {
    case value1:
        // code
        break;
    case value2:
        // code
        break;
    default:
        // code if no case matches
}
</pre>

                    <h3>Example — Day of the Week:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    int day;
    printf("Enter day number (1-7): ");
    scanf("%d", &amp;day);

    switch (day) {
        case 1:
            printf("Monday\n");
            break;
        case 2:
            printf("Tuesday\n");
            break;
        case 3:
            printf("Wednesday\n");
            break;
        case 4:
            printf("Thursday\n");
            break;
        case 5:
            printf("Friday\n");
            break;
        case 6:
            printf("Saturday\n");
            break;
        case 7:
            printf("Sunday\n");
            break;
        default:
            printf("Invalid day!\n");
    }

    return 0;
}
</pre>

                    <h3>Example — Simple Calculator:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    float a, b, result;
    char op;

    printf("Enter expression (e.g. 5 + 3): ");
    scanf("%f %c %f", &amp;a, &amp;op, &amp;b);

    switch (op) {
        case '+':
            result = a + b;
            printf("Result: %.2f\n", result);
            break;
        case '-':
            result = a - b;
            printf("Result: %.2f\n", result);
            break;
        case '*':
            result = a * b;
            printf("Result: %.2f\n", result);
            break;
        case '/':
            if (b != 0) {
                result = a / b;
                printf("Result: %.2f\n", result);
            } else {
                printf("Error: Division by zero!\n");
            }
            break;
        default:
            printf("Unknown operator!\n");
    }

    return 0;
}
</pre>

                    <h3>Example — Grade Checker using Switch:</h3>
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    char grade;
    printf("Enter your grade (A/B/C/D/F): ");
    scanf(" %c", &amp;grade);

    switch (grade) {
        case 'A':
            printf("Excellent!\n");
            break;
        case 'B':
            printf("Good job!\n");
            break;
        case 'C':
            printf("Average.\n");
            break;
        case 'D':
            printf("Below average.\n");
            break;
        case 'F':
            printf("Failed. Please retake.\n");
            break;
        default:
            printf("Invalid grade entered.\n");
    }

    return 0;
}
</pre>

                    <h3>Fall-Through (No Break):</h3>
                    <pre>
switch (num) {
    case 1:
    case 2:
    case 3:
        printf("Number is 1, 2, or 3\n");
        break;
    default:
        printf("Other number\n");
}
</pre>
                    <p>When multiple cases share the same code, you can stack them without <code>break</code>.</p>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Always add <code>break</code> after each case to prevent fall-through.</li>
                        <li><code>default</code> is optional but recommended as a safety net.</li>
                        <li>Switch works with <code>int</code> and <code>char</code> — NOT with <code>float</code> or <code>string</code>.</li>
                        <li>Each <code>case</code> value must be a constant, not a variable.</li>
                    </ul>

                    <form method="GET" action="{{ route('c.lesson5.quiz') }}">
                        <button>Quiz Lesson 5</button>
                    </form>
                @endif

                {{-- Final Exam --}}
                @if ($current_lesson < 6)
                    <hr>
                    <h2 id="final">Final Exam 🔒</h2>
                    <p style="color:gray;">Complete Lesson 5 Quiz to unlock the Final Exam.</p>
                @endif

                @if ($current_lesson >= 6)
                    <hr>
                    <h2 id="final">🎓 Final Exam</h2>
                    <form method="GET" action="{{ route('c.final.exam') }}">
                        <button>Take Final Exam</button>
                    </form>
                @endif

            @endif {{-- end !$showQuiz --}}


            {{-- ============================================================ --}}
            {{-- QUIZ SECTIONS                                                --}}
            {{-- ============================================================ --}}

            @if ($showQuiz === true)
                {{-- ── Lesson 1 Quiz ── --}}
                <h2>Lesson 1 Quiz — Introduction to C</h2>
                <form method="POST" action="{{ route('c.submit') }}">
                    @csrf

                    <p>1. Who created the C programming language?</p>
                    <input type="radio" name="q1" value="a"> Dennis Ritchie<br>
                    <input type="radio" name="q1" value="b"> Bjarne Stroustrup<br>
                    <input type="radio" name="q1" value="c"> Linus Torvalds<br>
                    <input type="radio" name="q1" value="d"> James Gosling<br><br>

                    <p>2. What is the correct file extension for a C source file?</p>
                    <input type="radio" name="q2" value="a"> .cpp<br>
                    <input type="radio" name="q2" value="b"> .java<br>
                    <input type="radio" name="q2" value="c"> .c<br>
                    <input type="radio" name="q2" value="d"> .py<br><br>

                    <p>3. Which function is used to print output in C?</p>
                    <input type="radio" name="q3" value="a"> print()<br>
                    <input type="radio" name="q3" value="b"> cout<br>
                    <input type="radio" name="q3" value="c"> echo()<br>
                    <input type="radio" name="q3" value="d"> printf()<br><br>

                    <p>4. Which header file is needed for printf and scanf?</p>
                    <input type="radio" name="q4" value="a"> &lt;math.h&gt;<br>
                    <input type="radio" name="q4" value="b"> &lt;string.h&gt;<br>
                    <input type="radio" name="q4" value="c"> &lt;stdio.h&gt;<br>
                    <input type="radio" name="q4" value="d"> &lt;stdlib.h&gt;<br><br>

                    <p>5. What does the main() function return in C?</p>
                    <input type="radio" name="q5" value="a"> void<br>
                    <input type="radio" name="q5" value="b"> float<br>
                    <input type="radio" name="q5" value="c"> char<br>
                    <input type="radio" name="q5" value="d"> int<br><br>

                    <p>6. What does "\n" do inside printf()?</p>
                    <input type="radio" name="q6" value="a"> Adds a tab<br>
                    <input type="radio" name="q6" value="b"> Adds a new line<br>
                    <input type="radio" name="q6" value="c"> Ends the program<br>
                    <input type="radio" name="q6" value="d"> Adds a space<br><br>

                    <p>7. What is the correct way to write a single-line comment in C?</p>
                    <input type="radio" name="q7" value="a"> # This is a comment<br>
                    <input type="radio" name="q7" value="b"> &lt;!-- This is a comment --&gt;<br>
                    <input type="radio" name="q7" value="c"> // This is a comment<br>
                    <input type="radio" name="q7" value="d"> /* This is a comment<br><br>

                    <p>8. Which of the following is a valid C program entry point?</p>
                    <input type="radio" name="q8" value="a"> void start()<br>
                    <input type="radio" name="q8" value="b"> int main()<br>
                    <input type="radio" name="q8" value="c"> begin()<br>
                    <input type="radio" name="q8" value="d"> run()<br><br>

                    <p>9. What does "return 0;" mean in the main function?</p>
                    <input type="radio" name="q9" value="a"> The program failed<br>
                    <input type="radio" name="q9" value="b"> The program loops back<br>
                    <input type="radio" name="q9" value="c"> The program ended successfully<br>
                    <input type="radio" name="q9" value="d"> The program pauses<br><br>

                    <p>10. What does "\t" represent in a printf() string?</p>
                    <input type="radio" name="q10" value="a"> New line<br>
                    <input type="radio" name="q10" value="b"> Backslash<br>
                    <input type="radio" name="q10" value="c"> Tab space<br>
                    <input type="radio" name="q10" value="d"> End of string<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson2')
                {{-- ── Lesson 2 Quiz ── --}}
                <h2>Lesson 2 Quiz — Data Types, Variables, printf & scanf</h2>
                <form method="POST" action="{{ route('c.lesson2.submit') }}">
                    @csrf

                    <p>1. Which data type is used to store a single character in C?</p>
                    <input type="radio" name="q1" value="a"> int<br>
                    <input type="radio" name="q1" value="b"> float<br>
                    <input type="radio" name="q1" value="c"> char<br>
                    <input type="radio" name="q1" value="d"> string<br><br>

                    <p>2. What format specifier is used for integers in printf?</p>
                    <input type="radio" name="q2" value="a"> %f<br>
                    <input type="radio" name="q2" value="b"> %c<br>
                    <input type="radio" name="q2" value="c"> %s<br>
                    <input type="radio" name="q2" value="d"> %d<br><br>

                    <p>3. Which symbol is required before a variable name in scanf?</p>
                    <input type="radio" name="q3" value="a"> *<br>
                    <input type="radio" name="q3" value="b"> &amp;<br>
                    <input type="radio" name="q3" value="c"> #<br>
                    <input type="radio" name="q3" value="d"> @<br><br>

                    <p>4. Which data type stores decimal numbers?</p>
                    <input type="radio" name="q4" value="a"> int<br>
                    <input type="radio" name="q4" value="b"> char<br>
                    <input type="radio" name="q4" value="c"> float<br>
                    <input type="radio" name="q4" value="d"> bool<br><br>

                    <p>5. What is the format specifier for a float?</p>
                    <input type="radio" name="q5" value="a"> %d<br>
                    <input type="radio" name="q5" value="b"> %f<br>
                    <input type="radio" name="q5" value="c"> %c<br>
                    <input type="radio" name="q5" value="d"> %s<br><br>

                    <p>6. Which of the following is a valid variable declaration in C?</p>
                    <input type="radio" name="q6" value="a"> variable int x;<br>
                    <input type="radio" name="q6" value="b"> x int = 5;<br>
                    <input type="radio" name="q6" value="c"> int x = 5;<br>
                    <input type="radio" name="q6" value="d"> int = x 5;<br><br>

                    <p>7. What does %.2f display?</p>
                    <input type="radio" name="q7" value="a"> An integer<br>
                    <input type="radio" name="q7" value="b"> A float with 2 decimal places<br>
                    <input type="radio" name="q7" value="c"> A character<br>
                    <input type="radio" name="q7" value="d"> A string<br><br>

                    <p>8. Which of the following is NOT a valid C data type?</p>
                    <input type="radio" name="q8" value="a"> int<br>
                    <input type="radio" name="q8" value="b"> float<br>
                    <input type="radio" name="q8" value="c"> string<br>
                    <input type="radio" name="q8" value="d"> char<br><br>

                    <p>9. What is the correct format specifier for a char?</p>
                    <input type="radio" name="q9" value="a"> %d<br>
                    <input type="radio" name="q9" value="b"> %f<br>
                    <input type="radio" name="q9" value="c"> %c<br>
                    <input type="radio" name="q9" value="d"> %s<br><br>

                    <p>10. Which function is used to read input from the user in C?</p>
                    <input type="radio" name="q10" value="a"> input()<br>
                    <input type="radio" name="q10" value="b"> read()<br>
                    <input type="radio" name="q10" value="c"> get()<br>
                    <input type="radio" name="q10" value="d"> scanf()<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson3')
                {{-- ── Lesson 3 Quiz ── --}}
                <h2>Lesson 3 Quiz — If-Else Statements</h2>
                <form method="POST" action="{{ route('c.lesson3.submit') }}">
                    @csrf

                    <p>1. Which symbol is used for the "equal to" comparison in C?</p>
                    <input type="radio" name="q1" value="a"> =<br>
                    <input type="radio" name="q1" value="b"> ===<br>
                    <input type="radio" name="q1" value="c"> ==<br>
                    <input type="radio" name="q1" value="d"> !=<br><br>

                    <p>2. What keyword is used for alternative conditions in C?</p>
                    <input type="radio" name="q2" value="a"> elif<br>
                    <input type="radio" name="q2" value="b"> elseif<br>
                    <input type="radio" name="q2" value="c"> else if<br>
                    <input type="radio" name="q2" value="d"> otherwise<br><br>

                    <p>3. What does the && operator mean?</p>
                    <input type="radio" name="q3" value="a"> OR<br>
                    <input type="radio" name="q3" value="b"> NOT<br>
                    <input type="radio" name="q3" value="c"> AND<br>
                    <input type="radio" name="q3" value="d"> XOR<br><br>

                    <p>4. What does the || operator mean?</p>
                    <input type="radio" name="q4" value="a"> AND<br>
                    <input type="radio" name="q4" value="b"> OR<br>
                    <input type="radio" name="q4" value="c"> NOT<br>
                    <input type="radio" name="q4" value="d"> EQUAL<br><br>

                    <p>5. Which of the following correctly checks if x is greater than 10?</p>
                    <input type="radio" name="q5" value="a"> if x &gt; 10<br>
                    <input type="radio" name="q5" value="b"> if (x &gt; 10)<br>
                    <input type="radio" name="q5" value="c"> if [x &gt; 10]<br>
                    <input type="radio" name="q5" value="d"> if {x &gt; 10}<br><br>

                    <p>6. What happens if the if condition is false and there is no else?</p>
                    <input type="radio" name="q6" value="a"> The program crashes<br>
                    <input type="radio" name="q6" value="b"> The if block runs anyway<br>
                    <input type="radio" name="q6" value="c"> Nothing happens, program continues<br>
                    <input type="radio" name="q6" value="d"> An error is thrown<br><br>

                    <p>7. Which operator means "not equal to"?</p>
                    <input type="radio" name="q7" value="a"> &lt;&gt;<br>
                    <input type="radio" name="q7" value="b"> ==<br>
                    <input type="radio" name="q7" value="c"> !=<br>
                    <input type="radio" name="q7" value="d"> !==<br><br>

                    <p>8. A nested if-else means:</p>
                    <input type="radio" name="q8" value="a"> Two separate if statements<br>
                    <input type="radio" name="q8" value="b"> An if inside another if<br>
                    <input type="radio" name="q8" value="c"> An else without an if<br>
                    <input type="radio" name="q8" value="d"> A loop inside an if<br><br>

                    <p>9. What is the correct syntax for an if statement in C?</p>
                    <input type="radio" name="q9" value="a"> if condition { }<br>
                    <input type="radio" name="q9" value="b"> if [condition] { }<br>
                    <input type="radio" name="q9" value="c"> if (condition) { }<br>
                    <input type="radio" name="q9" value="d"> if &lt;condition&gt; { }<br><br>

                    <p>10. The "!" operator in C is used for?</p>
                    <input type="radio" name="q10" value="a"> Multiplication<br>
                    <input type="radio" name="q10" value="b"> Division<br>
                    <input type="radio" name="q10" value="c"> Logical NOT<br>
                    <input type="radio" name="q10" value="d"> Modulus<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson4')
                {{-- ── Lesson 4 Quiz ── --}}
                <h2>Lesson 4 Quiz — Loops</h2>
                <form method="POST" action="{{ route('c.lesson4.submit') }}">
                    @csrf

                    <p>1. Which loop is best when the number of iterations is known?</p>
                    <input type="radio" name="q1" value="a"> while<br>
                    <input type="radio" name="q1" value="b"> do-while<br>
                    <input type="radio" name="q1" value="c"> for<br>
                    <input type="radio" name="q1" value="d"> switch<br><br>

                    <p>2. What is the correct syntax of a for loop in C?</p>
                    <input type="radio" name="q2" value="a"> for (init, condition, update)<br>
                    <input type="radio" name="q2" value="b"> for [init; condition; update]<br>
                    <input type="radio" name="q2" value="c"> for (init; condition; update)<br>
                    <input type="radio" name="q2" value="d"> loop (init; condition; update)<br><br>

                    <p>3. What keyword immediately exits a loop in C?</p>
                    <input type="radio" name="q3" value="a"> exit<br>
                    <input type="radio" name="q3" value="b"> stop<br>
                    <input type="radio" name="q3" value="c"> return<br>
                    <input type="radio" name="q3" value="d"> break<br><br>

                    <p>4. What keyword skips the current iteration of a loop?</p>
                    <input type="radio" name="q4" value="a"> skip<br>
                    <input type="radio" name="q4" value="b"> next<br>
                    <input type="radio" name="q4" value="c"> continue<br>
                    <input type="radio" name="q4" value="d"> pass<br><br>

                    <p>5. Which loop always executes its body at least once?</p>
                    <input type="radio" name="q5" value="a"> for<br>
                    <input type="radio" name="q5" value="b"> while<br>
                    <input type="radio" name="q5" value="c"> do-while<br>
                    <input type="radio" name="q5" value="d"> foreach<br><br>

                    <p>6. How many times does this loop execute? for(int i=0; i&lt;5; i++)</p>
                    <input type="radio" name="q6" value="a"> 4<br>
                    <input type="radio" name="q6" value="b"> 6<br>
                    <input type="radio" name="q6" value="c"> 5<br>
                    <input type="radio" name="q6" value="d"> Infinite<br><br>

                    <p>7. What is a nested loop?</p>
                    <input type="radio" name="q7" value="a"> A loop with no condition<br>
                    <input type="radio" name="q7" value="b"> A loop inside another loop<br>
                    <input type="radio" name="q7" value="c"> A loop that runs once<br>
                    <input type="radio" name="q7" value="d"> A loop with break<br><br>

                    <p>8. Which loop checks the condition AFTER executing the body?</p>
                    <input type="radio" name="q8" value="a"> for<br>
                    <input type="radio" name="q8" value="b"> while<br>
                    <input type="radio" name="q8" value="c"> do-while<br>
                    <input type="radio" name="q8" value="d"> switch<br><br>

                    <p>9. What does i++ mean in a for loop?</p>
                    <input type="radio" name="q9" value="a"> Decrease i by 1<br>
                    <input type="radio" name="q9" value="b"> Reset i to 0<br>
                    <input type="radio" name="q9" value="c"> Multiply i by 2<br>
                    <input type="radio" name="q9" value="d"> Increase i by 1<br><br>

                    <p>10. Which pattern requires a nested for loop?</p>
                    <input type="radio" name="q10" value="a"> Printing a single number<br>
                    <input type="radio" name="q10" value="b"> Reading user input<br>
                    <input type="radio" name="q10" value="c"> Printing a star triangle<br>
                    <input type="radio" name="q10" value="d"> Declaring a variable<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson5')
                {{-- ── Lesson 5 Quiz ── --}}
                <h2>Lesson 5 Quiz — Switch Case</h2>
                <form method="POST" action="{{ route('c.lesson5.submit') }}">
                    @csrf

                    <p>1. What keyword starts a switch statement?</p>
                    <input type="radio" name="q1" value="a"> case<br>
                    <input type="radio" name="q1" value="b"> select<br>
                    <input type="radio" name="q1" value="c"> switch<br>
                    <input type="radio" name="q1" value="d"> choose<br><br>

                    <p>2. What keyword prevents fall-through in a switch?</p>
                    <input type="radio" name="q2" value="a"> stop<br>
                    <input type="radio" name="q2" value="b"> exit<br>
                    <input type="radio" name="q2" value="c"> end<br>
                    <input type="radio" name="q2" value="d"> break<br><br>

                    <p>3. What is the default case in a switch used for?</p>
                    <input type="radio" name="q3" value="a"> The first matching case<br>
                    <input type="radio" name="q3" value="b"> When no case matches<br>
                    <input type="radio" name="q3" value="c"> To end the switch<br>
                    <input type="radio" name="q3" value="d"> To loop the switch<br><br>

                    <p>4. Which data type CANNOT be used in a switch expression?</p>
                    <input type="radio" name="q4" value="a"> int<br>
                    <input type="radio" name="q4" value="b"> char<br>
                    <input type="radio" name="q4" value="c"> float<br>
                    <input type="radio" name="q4" value="d"> long<br><br>

                    <p>5. What happens if break is missing in a case?</p>
                    <input type="radio" name="q5" value="a"> The program crashes<br>
                    <input type="radio" name="q5" value="b"> Only that case runs<br>
                    <input type="radio" name="q5" value="c"> Execution falls through to the next case<br>
                    <input type="radio" name="q5" value="d"> The default case runs<br><br>

                    <p>6. Is the default case required in a switch statement?</p>
                    <input type="radio" name="q6" value="a"> Yes, always<br>
                    <input type="radio" name="q6" value="b"> No, it is optional<br>
                    <input type="radio" name="q6" value="c"> Yes, it must come first<br>
                    <input type="radio" name="q6" value="d"> No, it causes errors<br><br>

                    <p>7. Can multiple cases share the same code block (fall-through)?</p>
                    <input type="radio" name="q7" value="a"> No<br>
                    <input type="radio" name="q7" value="b"> Only with int<br>
                    <input type="radio" name="q7" value="c"> Yes<br>
                    <input type="radio" name="q7" value="d"> Only in C++<br><br>

                    <p>8. A switch statement is best used when:</p>
                    <input type="radio" name="q8" value="a"> Comparing floating point values<br>
                    <input type="radio" name="q8" value="b"> Comparing one variable to many fixed values<br>
                    <input type="radio" name="q8" value="c"> Writing loops<br>
                    <input type="radio" name="q8" value="d"> Declaring variables<br><br>

                    <p>9. What is the correct structure of a case label?</p>
                    <input type="radio" name="q9" value="a"> case = 1:<br>
                    <input type="radio" name="q9" value="b"> case 1;<br>
                    <input type="radio" name="q9" value="c"> case (1):<br>
                    <input type="radio" name="q9" value="d"> case 1:<br><br>

                    <p>10. Switch in C is an alternative to:</p>
                    <input type="radio" name="q10" value="a"> for loop<br>
                    <input type="radio" name="q10" value="b"> while loop<br>
                    <input type="radio" name="q10" value="c"> long if-else if chains<br>
                    <input type="radio" name="q10" value="d"> printf<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'final')
                {{-- ── Final Exam (50 questions) ── --}}
                <h2>🎓 C Programming Final Exam</h2>
                <p>This exam covers all lessons. Answer all 50 questions.</p>

                <form method="POST" action="{{ route('c.final.submit') }}">
                    @csrf

                    <h3>— Introduction to C (Q1–10) —</h3>

                    <p>1. Who created C?</p>
                    <input type="radio" name="q1" value="a"> Dennis Ritchie<br>
                    <input type="radio" name="q1" value="b"> Bjarne Stroustrup<br>
                    <input type="radio" name="q1" value="c"> James Gosling<br>
                    <input type="radio" name="q1" value="d"> Guido van Rossum<br><br>

                    <p>2. What is the correct file extension for C?</p>
                    <input type="radio" name="q2" value="a"> .cpp<br>
                    <input type="radio" name="q2" value="b"> .py<br>
                    <input type="radio" name="q2" value="c"> .c<br>
                    <input type="radio" name="q2" value="d"> .java<br><br>

                    <p>3. Which header is required for printf?</p>
                    <input type="radio" name="q3" value="a"> &lt;math.h&gt;<br>
                    <input type="radio" name="q3" value="b"> &lt;string.h&gt;<br>
                    <input type="radio" name="q3" value="c"> &lt;stdlib.h&gt;<br>
                    <input type="radio" name="q3" value="d"> &lt;stdio.h&gt;<br><br>

                    <p>4. Every C program starts execution from?</p>
                    <input type="radio" name="q4" value="a"> start()<br>
                    <input type="radio" name="q4" value="b"> begin()<br>
                    <input type="radio" name="q4" value="c"> main()<br>
                    <input type="radio" name="q4" value="d"> run()<br><br>

                    <p>5. What does return 0 in main() indicate?</p>
                    <input type="radio" name="q5" value="a"> Error<br>
                    <input type="radio" name="q5" value="b"> Loop again<br>
                    <input type="radio" name="q5" value="c"> Successful execution<br>
                    <input type="radio" name="q5" value="d"> Skip output<br><br>

                    <p>6. What does \n do in printf?</p>
                    <input type="radio" name="q6" value="a"> Tab<br>
                    <input type="radio" name="q6" value="b"> Newline<br>
                    <input type="radio" name="q6" value="c"> Space<br>
                    <input type="radio" name="q6" value="d"> Backslash<br><br>

                    <p>7. What does \t do in printf?</p>
                    <input type="radio" name="q7" value="a"> Newline<br>
                    <input type="radio" name="q7" value="b"> End program<br>
                    <input type="radio" name="q7" value="c"> Tab<br>
                    <input type="radio" name="q7" value="d"> Null character<br><br>

                    <p>8. How do you write a single-line comment in C?</p>
                    <input type="radio" name="q8" value="a"> # comment<br>
                    <input type="radio" name="q8" value="b"> // comment<br>
                    <input type="radio" name="q8" value="c"> &lt;!-- comment --&gt;<br>
                    <input type="radio" name="q8" value="d"> /* comment<br><br>

                    <p>9. Every statement in C ends with?</p>
                    <input type="radio" name="q9" value="a"> .<br>
                    <input type="radio" name="q9" value="b"> :<br>
                    <input type="radio" name="q9" value="c"> ;<br>
                    <input type="radio" name="q9" value="d"> ,<br><br>

                    <p>10. C is case-sensitive. True or False?</p>
                    <input type="radio" name="q10" value="a"> False<br>
                    <input type="radio" name="q10" value="b"> Only for functions<br>
                    <input type="radio" name="q10" value="c"> Only for variables<br>
                    <input type="radio" name="q10" value="d"> True<br><br>

                    <h3>— Data Types & Variables (Q11–20) —</h3>

                    <p>11. Which data type stores whole numbers?</p>
                    <input type="radio" name="q11" value="a"> float<br>
                    <input type="radio" name="q11" value="b"> char<br>
                    <input type="radio" name="q11" value="c"> int<br>
                    <input type="radio" name="q11" value="d"> double<br><br>

                    <p>12. Which format specifier is used for int?</p>
                    <input type="radio" name="q12" value="a"> %f<br>
                    <input type="radio" name="q12" value="b"> %c<br>
                    <input type="radio" name="q12" value="c"> %s<br>
                    <input type="radio" name="q12" value="d"> %d<br><br>

                    <p>13. What symbol is required before variable names in scanf?</p>
                    <input type="radio" name="q13" value="a"> *<br>
                    <input type="radio" name="q13" value="b"> #<br>
                    <input type="radio" name="q13" value="c"> &amp;<br>
                    <input type="radio" name="q13" value="d"> @<br><br>

                    <p>14. Which is used to store decimal numbers?</p>
                    <input type="radio" name="q14" value="a"> int<br>
                    <input type="radio" name="q14" value="b"> char<br>
                    <input type="radio" name="q14" value="c"> bool<br>
                    <input type="radio" name="q14" value="d"> float<br><br>

                    <p>15. What does %.2f display?</p>
                    <input type="radio" name="q15" value="a"> Integer<br>
                    <input type="radio" name="q15" value="b"> Float with 2 decimal places<br>
                    <input type="radio" name="q15" value="c"> Character<br>
                    <input type="radio" name="q15" value="d"> String<br><br>

                    <p>16. Which is NOT a valid C data type?</p>
                    <input type="radio" name="q16" value="a"> int<br>
                    <input type="radio" name="q16" value="b"> float<br>
                    <input type="radio" name="q16" value="c"> string<br>
                    <input type="radio" name="q16" value="d"> char<br><br>

                    <p>17. Format specifier for char is?</p>
                    <input type="radio" name="q17" value="a"> %d<br>
                    <input type="radio" name="q17" value="b"> %f<br>
                    <input type="radio" name="q17" value="c"> %c<br>
                    <input type="radio" name="q17" value="d"> %s<br><br>

                    <p>18. Valid variable declaration in C?</p>
                    <input type="radio" name="q18" value="a"> variable int x;<br>
                    <input type="radio" name="q18" value="b"> int x = 5;<br>
                    <input type="radio" name="q18" value="c"> x int = 5;<br>
                    <input type="radio" name="q18" value="d"> int = x 5;<br><br>

                    <p>19. Function used to read user input in C?</p>
                    <input type="radio" name="q19" value="a"> input()<br>
                    <input type="radio" name="q19" value="b"> read()<br>
                    <input type="radio" name="q19" value="c"> get()<br>
                    <input type="radio" name="q19" value="d"> scanf()<br><br>

                    <p>20. double stores?</p>
                    <input type="radio" name="q20" value="a"> Small integers<br>
                    <input type="radio" name="q20" value="b"> Single characters<br>
                    <input type="radio" name="q20" value="c"> Large decimal numbers<br>
                    <input type="radio" name="q20" value="d"> Boolean values<br><br>

                    <h3>— If-Else Statements (Q21–30) —</h3>

                    <p>21. Which operator checks equality?</p>
                    <input type="radio" name="q21" value="a"> =<br>
                    <input type="radio" name="q21" value="b"> ==<br>
                    <input type="radio" name="q21" value="c"> ===<br>
                    <input type="radio" name="q21" value="d"> !=<br><br>

                    <p>22. What does && mean?</p>
                    <input type="radio" name="q22" value="a"> OR<br>
                    <input type="radio" name="q22" value="b"> NOT<br>
                    <input type="radio" name="q22" value="c"> AND<br>
                    <input type="radio" name="q22" value="d"> XOR<br><br>

                    <p>23. What does || mean?</p>
                    <input type="radio" name="q23" value="a"> AND<br>
                    <input type="radio" name="q23" value="b"> OR<br>
                    <input type="radio" name="q23" value="c"> NOT<br>
                    <input type="radio" name="q23" value="d"> EQUAL<br><br>

                    <p>24. Correct if syntax in C?</p>
                    <input type="radio" name="q24" value="a"> if condition { }<br>
                    <input type="radio" name="q24" value="b"> if [condition] { }<br>
                    <input type="radio" name="q24" value="c"> if (condition) { }<br>
                    <input type="radio" name="q24" value="d"> if &lt;condition&gt; { }<br><br>

                    <p>25. What does != mean?</p>
                    <input type="radio" name="q25" value="a"> Equal to<br>
                    <input type="radio" name="q25" value="b"> Greater than<br>
                    <input type="radio" name="q25" value="c"> Less than<br>
                    <input type="radio" name="q25" value="d"> Not equal to<br><br>

                    <p>26. Nested if-else means?</p>
                    <input type="radio" name="q26" value="a"> Two separate if statements<br>
                    <input type="radio" name="q26" value="b"> An if inside another if<br>
                    <input type="radio" name="q26" value="c"> An else without if<br>
                    <input type="radio" name="q26" value="d"> A loop inside if<br><br>

                    <p>27. The ! operator means?</p>
                    <input type="radio" name="q27" value="a"> Multiply<br>
                    <input type="radio" name="q27" value="b"> Divide<br>
                    <input type="radio" name="q27" value="c"> Logical NOT<br>
                    <input type="radio" name="q27" value="d"> Modulus<br><br>

                    <p>28. Keyword for additional conditions?</p>
                    <input type="radio" name="q28" value="a"> elif<br>
                    <input type="radio" name="q28" value="b"> elseif<br>
                    <input type="radio" name="q28" value="c"> else if<br>
                    <input type="radio" name="q28" value="d"> otherwise<br><br>

                    <p>29. If condition is false and no else exists?</p>
                    <input type="radio" name="q29" value="a"> Program crashes<br>
                    <input type="radio" name="q29" value="b"> If block runs<br>
                    <input type="radio" name="q29" value="c"> Nothing, continues normally<br>
                    <input type="radio" name="q29" value="d"> Error thrown<br><br>

                    <p>30. Which is >= used for?</p>
                    <input type="radio" name="q30" value="a"> Less than<br>
                    <input type="radio" name="q30" value="b"> Equal only<br>
                    <input type="radio" name="q30" value="c"> Greater than or equal to<br>
                    <input type="radio" name="q30" value="d"> Not equal<br><br>

                    <h3>— Loops (Q31–40) —</h3>

                    <p>31. Best loop when iterations are known?</p>
                    <input type="radio" name="q31" value="a"> while<br>
                    <input type="radio" name="q31" value="b"> do-while<br>
                    <input type="radio" name="q31" value="c"> for<br>
                    <input type="radio" name="q31" value="d"> switch<br><br>

                    <p>32. Loop that runs at least once?</p>
                    <input type="radio" name="q32" value="a"> for<br>
                    <input type="radio" name="q32" value="b"> while<br>
                    <input type="radio" name="q32" value="c"> do-while<br>
                    <input type="radio" name="q32" value="d"> foreach<br><br>

                    <p>33. Keyword to exit a loop?</p>
                    <input type="radio" name="q33" value="a"> exit<br>
                    <input type="radio" name="q33" value="b"> stop<br>
                    <input type="radio" name="q33" value="c"> break<br>
                    <input type="radio" name="q33" value="d"> return<br><br>

                    <p>34. Keyword to skip current iteration?</p>
                    <input type="radio" name="q34" value="a"> skip<br>
                    <input type="radio" name="q34" value="b"> next<br>
                    <input type="radio" name="q34" value="c"> continue<br>
                    <input type="radio" name="q34" value="d"> pass<br><br>

                    <p>35. How many times does for(i=0; i&lt;5; i++) run?</p>
                    <input type="radio" name="q35" value="a"> 4<br>
                    <input type="radio" name="q35" value="b"> 6<br>
                    <input type="radio" name="q35" value="c"> 5<br>
                    <input type="radio" name="q35" value="d"> Infinite<br><br>

                    <p>36. A loop inside another loop is called?</p>
                    <input type="radio" name="q36" value="a"> Double loop<br>
                    <input type="radio" name="q36" value="b"> Nested loop<br>
                    <input type="radio" name="q36" value="c"> Inner loop<br>
                    <input type="radio" name="q36" value="d"> Super loop<br><br>

                    <p>37. Which loop checks condition AFTER the body?</p>
                    <input type="radio" name="q37" value="a"> for<br>
                    <input type="radio" name="q37" value="b"> while<br>
                    <input type="radio" name="q37" value="c"> do-while<br>
                    <input type="radio" name="q37" value="d"> switch<br><br>

                    <p>38. What does i++ do?</p>
                    <input type="radio" name="q38" value="a"> Decrease i by 1<br>
                    <input type="radio" name="q38" value="b"> Reset i<br>
                    <input type="radio" name="q38" value="c"> Multiply i by 2<br>
                    <input type="radio" name="q38" value="d"> Increase i by 1<br><br>

                    <p>39. Nested loops are used to print?</p>
                    <input type="radio" name="q39" value="a"> Simple text<br>
                    <input type="radio" name="q39" value="b"> Star patterns and grids<br>
                    <input type="radio" name="q39" value="c"> Single numbers<br>
                    <input type="radio" name="q39" value="d"> Variables only<br><br>

                    <p>40. A while loop syntax is?</p>
                    <input type="radio" name="q40" value="a"> while condition { }<br>
                    <input type="radio" name="q40" value="b"> while (condition) { }<br>
                    <input type="radio" name="q40" value="c"> while [condition] { }<br>
                    <input type="radio" name="q40" value="d"> loop (condition) { }<br><br>

                    <h3>— Switch Case (Q41–50) —</h3>

                    <p>41. Keyword to start a switch?</p>
                    <input type="radio" name="q41" value="a"> case<br>
                    <input type="radio" name="q41" value="b"> select<br>
                    <input type="radio" name="q41" value="c"> switch<br>
                    <input type="radio" name="q41" value="d"> choose<br><br>

                    <p>42. Keyword to prevent fall-through?</p>
                    <input type="radio" name="q42" value="a"> stop<br>
                    <input type="radio" name="q42" value="b"> break<br>
                    <input type="radio" name="q42" value="c"> exit<br>
                    <input type="radio" name="q42" value="d"> end<br><br>

                    <p>43. Default case runs when?</p>
                    <input type="radio" name="q43" value="a"> First case<br>
                    <input type="radio" name="q43" value="b"> No case matches<br>
                    <input type="radio" name="q43" value="c"> Every time<br>
                    <input type="radio" name="q43" value="d"> After break<br><br>

                    <p>44. Which type CANNOT be used in switch?</p>
                    <input type="radio" name="q44" value="a"> int<br>
                    <input type="radio" name="q44" value="b"> char<br>
                    <input type="radio" name="q44" value="c"> float<br>
                    <input type="radio" name="q44" value="d"> long<br><br>

                    <p>45. Missing break causes?</p>
                    <input type="radio" name="q45" value="a"> Crash<br>
                    <input type="radio" name="q45" value="b"> Only that case runs<br>
                    <input type="radio" name="q45" value="c"> Fall-through to next case<br>
                    <input type="radio" name="q45" value="d"> Default runs<br><br>

                    <p>46. Is default required in switch?</p>
                    <input type="radio" name="q46" value="a"> Yes always<br>
                    <input type="radio" name="q46" value="b"> No, optional<br>
                    <input type="radio" name="q46" value="c"> Yes, must come first<br>
                    <input type="radio" name="q46" value="d"> No, causes errors<br><br>

                    <p>47. Multiple cases sharing code is called?</p>
                    <input type="radio" name="q47" value="a"> Grouping<br>
                    <input type="radio" name="q47" value="b"> Nesting<br>
                    <input type="radio" name="q47" value="c"> Fall-through<br>
                    <input type="radio" name="q47" value="d"> Cascading<br><br>

                    <p>48. Switch is an alternative to?</p>
                    <input type="radio" name="q48" value="a"> for loop<br>
                    <input type="radio" name="q48" value="b"> while loop<br>
                    <input type="radio" name="q48" value="c"> long if-else if chains<br>
                    <input type="radio" name="q48" value="d"> printf<br><br>

                    <p>49. Correct case label syntax?</p>
                    <input type="radio" name="q49" value="a"> case = 1:<br>
                    <input type="radio" name="q49" value="b"> case 1;<br>
                    <input type="radio" name="q49" value="c"> case 1:<br>
                    <input type="radio" name="q49" value="d"> case (1):<br><br>

                    <p>50. Switch works best when?</p>
                    <input type="radio" name="q50" value="a"> Comparing floats<br>
                    <input type="radio" name="q50" value="b"> Writing loops<br>
                    <input type="radio" name="q50" value="c"> Declaring variables<br>
                    <input type="radio" name="q50" value="d"> Comparing one variable to many fixed values<br><br>

                    <button type="submit">Submit Final Exam</button>
                </form>

            @endif {{-- end quiz sections --}}

        </div>
    </div>

</body>
</html>
