<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Java Programming Course</title>
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
                            'java_lesson1' => route('java.course') . '#lesson2',
                            'java_lesson2' => route('java.course') . '#lesson3',
                            'java_lesson3' => route('java.course') . '#lesson4',
                            'java_lesson4' => route('java.course') . '#lesson5',
                            'java_lesson5' => route('java.course') . '#final',
                            'java_final'   => route('dashboard'),
                            default        => route('java.course'),
                        };
                        $nextLabel = session('quiz') === 'java_final' ? 'Back to Dashboard' : 'Proceed to Next Lesson →';
                    @endphp
                    <a href="{{ $nextRoute }}">
                        <button type="button">{{ $nextLabel }}</button>
                    </a>
                @else
                    @php
                        $retakeRoute = match(session('quiz')) {
                            'java_lesson1' => route('java.quiz'),
                            'java_lesson2' => route('java.lesson2.quiz'),
                            'java_lesson3' => route('java.lesson3.quiz'),
                            'java_lesson4' => route('java.lesson4.quiz'),
                            'java_lesson5' => route('java.lesson5.quiz'),
                            'java_final'   => route('java.final.exam'),
                            default        => route('java.quiz'),
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
                    <button type="button">View Java Certificate</button>
                </a>
            </div>
        @endif

        <div class="lesson-box">

            {{-- ============================================================ --}}
            {{-- LESSON CONTENT                                               --}}
            {{-- ============================================================ --}}
            @if (!$showQuiz)

                {{-- ── LESSON 1 ── --}}
                <h2>Lesson 1: Introduction to Java</h2>

                <p><b>Java</b> is a high-level, object-oriented, platform-independent programming language created by James Gosling at Sun Microsystems in 1995. It follows the "Write Once, Run Anywhere" (WORA) principle — Java programs are compiled into <b>bytecode</b> that runs on the <b>Java Virtual Machine (JVM)</b>, making them portable across all operating systems.</p>

                <h3>Why Learn Java?</h3>
                <ul>
                    <li>Platform-independent — runs on any OS with a JVM</li>
                    <li>Object-oriented — organizes code into reusable classes</li>
                    <li>Used in Android development, web backends, and enterprise software</li>
                    <li>Strongly typed — catches errors at compile time</li>
                    <li>Automatic memory management via Garbage Collection</li>
                </ul>

                <h3>Basic Structure of a Java Program:</h3>
                <pre>
public class HelloWorld {
    public static void main(String[] args) {
        System.out.println("Hello, World!");
    }
}
</pre>

                <h3>Explanation of Each Part:</h3>
                <pre>
public class HelloWorld
The program must be inside a class. The class name must match the filename (HelloWorld.java).
"public" means it is accessible from anywhere.

public static void main(String[] args)
This is the entry point — every Java program starts here.
"public"  → accessible by the JVM
"static"  → no object needed to call it
"void"    → returns nothing
"String[] args" → command-line arguments (array of Strings)

{
Opening curly brace — starts the block.

    System.out.println("Hello, World!");
Prints text followed by a newline to the console.
"System"     → built-in Java class
"out"        → the standard output stream
"println()"  → print + new line

}
Closing curly brace — ends the block.
</pre>

                <h3>Important Notes:</h3>
                <ul>
                    <li>Every Java file must have <strong>exactly one public class</strong> matching the filename.</li>
                    <li>Statements end with a semicolon <code>;</code></li>
                    <li>Java is <strong>case-sensitive</strong> — <code>Main</code> and <code>main</code> are different.</li>
                    <li>Use <code>//</code> for single-line comments and <code>/* */</code> for multi-line comments.</li>
                    <li>Java programs are compiled with <code>javac HelloWorld.java</code> and run with <code>java HelloWorld</code>.</li>
                </ul>

                <h2>Lesson 1.1: Comments and Basic Output</h2>

                <h3>Comments:</h3>
                <pre>
// This is a single-line comment

/* This is a
   multi-line comment */

/**
 * This is a Javadoc comment used to document classes and methods.
 */
</pre>

                <h3>println() vs print():</h3>
                <pre>
System.out.println("Hello!");     // prints and moves to next line
System.out.print("Hello! ");      // prints WITHOUT moving to next line
System.out.printf("Age: %d\n", 20); // formatted output (like C's printf)
</pre>

                <h3>Output Example:</h3>
                <pre>
public class Output {
    public static void main(String[] args) {
        System.out.println("Line 1");
        System.out.println("Line 2");
        System.out.print("No ");
        System.out.print("newline here\n");
    }
}
</pre>

                <h3>Output:</h3>
                <pre>
Line 1
Line 2
No newline here
</pre>

                <h3>Escape Sequences:</h3>
                <pre>
\n   → New line
\t   → Tab space
\\   → Backslash
\"   → Double quote
\'   → Single quote
</pre>

                <form method="GET" action="{{ route('java.quiz') }}">
                    <button>Quiz Lesson 1</button>
                </form>

                {{-- Lesson 2 --}}
                @if ($current_lesson < 2)
                    <hr><h2>Lesson 2 🔒</h2>
                    <p style="color:gray;">Complete Lesson 1 Quiz to unlock this lesson.</p>
                @endif

                @if ($current_lesson >= 2)
                    <hr>
                    <h2 id="lesson2">Lesson 2: Data Types and Variables</h2>

                    <p>Java is a <b>statically typed</b> language — every variable must have a declared type. Java has two categories: <b>primitive types</b> (stored by value) and <b>reference types</b> (stored by reference, e.g., String, arrays, objects).</p>

                    <h3>Primitive Data Types:</h3>
                    <pre>
byte    → 8-bit integer          (-128 to 127)
short   → 16-bit integer         (-32,768 to 32,767)
int     → 32-bit integer         (-2.1B to 2.1B)     ← most common
long    → 64-bit integer         (very large numbers)
float   → 32-bit decimal         (e.g. 3.14f)
double  → 64-bit decimal         (e.g. 3.14159265)   ← most common
char    → single Unicode char    (e.g. 'A')
boolean → true or false
</pre>

                    <h3>Declaring and Initializing Variables:</h3>
                    <pre>
int age = 20;
double price = 99.99;
boolean isJavaFun = true;
char grade = 'A';
String name = "Alice";    // String is a reference type (capital S)
long population = 8000000000L;   // add L for long literals
float temperature = 36.6f;       // add f for float literals
</pre>

                    <h3>Constants with final:</h3>
                    <pre>
final int MAX_SCORE = 100;   // cannot be changed after assignment
final double PI = 3.14159;
</pre>

                    <h3>Printing Variables:</h3>
                    <pre>
public class Variables {
    public static void main(String[] args) {
        int age = 20;
        double gpa = 3.75;
        char grade = 'A';
        String name = "Alice";

        System.out.println("Name: " + name);
        System.out.println("Age: " + age);
        System.out.println("GPA: " + gpa);
        System.out.println("Grade: " + grade);

        // Using printf (like C)
        System.out.printf("Name: %s, Age: %d, GPA: %.2f%n", name, age, gpa);
    }
}
</pre>

                    <h3>Format Specifiers for printf:</h3>
                    <pre>
%d   → int / long
%f   → float / double
%.2f → float with 2 decimal places
%c   → char
%s   → String
%b   → boolean
%n   → newline (platform-safe, preferred over \n in printf)
</pre>

                    <h3>Reading Input with Scanner:</h3>
                    <pre>
import java.util.Scanner;

public class Input {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        System.out.print("Enter your name: ");
        String name = sc.nextLine();

        System.out.print("Enter your age: ");
        int age = sc.nextInt();

        System.out.println("Hello, " + name + "! You are " + age + " years old.");

        sc.close();
    }
}
</pre>

                    <h3>Scanner Methods:</h3>
                    <pre>
sc.nextInt()     → reads an int
sc.nextDouble()  → reads a double
sc.nextLine()    → reads a full line (String)
sc.next()        → reads one word (String)
sc.nextBoolean() → reads true or false
</pre>

                    <h3>Type Casting:</h3>
                    <pre>
// Widening (automatic — no data loss)
int x = 10;
double d = x;         // d = 10.0 (int → double automatically)

// Narrowing (manual cast — may lose data)
double pi = 3.99;
int n = (int) pi;     // n = 3 (decimal is truncated, not rounded)

// String to int
String s = "42";
int num = Integer.parseInt(s);   // num = 42

// int to String
String str = String.valueOf(num);  // str = "42"
// or:
String str2 = Integer.toString(num);
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Always import <code>java.util.Scanner</code> before using Scanner.</li>
                        <li>Use <code>sc.nextLine()</code> after <code>sc.nextInt()</code> to consume the leftover newline.</li>
                        <li>String is a class (reference type) — use <code>.equals()</code> to compare Strings, NOT <code>==</code>.</li>
                        <li><code>final</code> variables (constants) are written in ALL_CAPS by convention.</li>
                    </ul>

                    <form method="GET" action="{{ route('java.lesson2.quiz') }}">
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
                    <h2 id="lesson3">Lesson 3: Control Flow — If-Else and Switch</h2>

                    <p>Control flow statements allow your program to make decisions. Java uses <code>if</code>, <code>else if</code>, <code>else</code>, and <code>switch</code> to branch execution based on conditions.</p>

                    <h3>Basic if-else Syntax:</h3>
                    <pre>
if (condition) {
    // runs if condition is TRUE
} else {
    // runs if condition is FALSE
}
</pre>

                    <h3>Example — Pass or Fail:</h3>
                    <pre>
import java.util.Scanner;

public class PassFail {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        System.out.print("Enter your score: ");
        int score = sc.nextInt();

        if (score >= 75) {
            System.out.println("You PASSED!");
        } else {
            System.out.println("You FAILED!");
        }
    }
}
</pre>

                    <h3>else if — Multiple Conditions:</h3>
                    <pre>
if (score >= 90) {
    System.out.println("Grade: A");
} else if (score >= 80) {
    System.out.println("Grade: B");
} else if (score >= 70) {
    System.out.println("Grade: C");
} else if (score >= 60) {
    System.out.println("Grade: D");
} else {
    System.out.println("Grade: F");
}
</pre>

                    <h3>Comparison Operators:</h3>
                    <pre>
==   → equal to
!=   → not equal to
>    → greater than
<    → less than
>=   → greater than or equal
<=   → less than or equal
</pre>

                    <h3>Logical Operators:</h3>
                    <pre>
&&   → AND  (both conditions must be true)
||   → OR   (at least one must be true)
!    → NOT  (reverses true/false)
</pre>

                    <h3>Switch Statement:</h3>
                    <pre>
switch (expression) {
    case value1:
        // code
        break;
    case value2:
        // code
        break;
    default:
        // runs when no case matches
}
</pre>

                    <h3>Example — Day of Week:</h3>
                    <pre>
int day = 3;
switch (day) {
    case 1:
        System.out.println("Monday");
        break;
    case 2:
        System.out.println("Tuesday");
        break;
    case 3:
        System.out.println("Wednesday");
        break;
    default:
        System.out.println("Other day");
}
// Output: Wednesday
</pre>

                    <h3>Switch works with:</h3>
                    <pre>
int, byte, short, char, String, and enum
Note: switch does NOT work with float, double, or long.
</pre>

                    <h3>Ternary Operator (shorthand if-else):</h3>
                    <pre>
// syntax: condition ? valueIfTrue : valueIfFalse
int age = 20;
String result = (age >= 18) ? "Adult" : "Minor";
System.out.println(result);  // Adult
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Use <code>==</code> to compare primitives; use <code>.equals()</code> to compare Strings.</li>
                        <li>Always add <code>break;</code> in switch cases to prevent fall-through.</li>
                        <li>Conditions must be inside parentheses <code>()</code>.</li>
                        <li><code>default</code> in switch is optional but recommended.</li>
                    </ul>

                    <form method="GET" action="{{ route('java.lesson3.quiz') }}">
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
                    <h2 id="lesson4">Lesson 4: Loops in Java</h2>

                    <p>Loops allow you to repeat a block of code multiple times. Java has four types of loops: <b>for</b>, <b>while</b>, <b>do-while</b>, and the enhanced <b>for-each</b> loop.</p>

                    <h2>Lesson 4.1: For Loop</h2>
                    <pre>
for (initialization; condition; update) {
    // code to repeat
}
</pre>

                    <h3>Example:</h3>
                    <pre>
public class ForLoop {
    public static void main(String[] args) {
        for (int i = 1; i <= 5; i++) {
            System.out.println(i);
        }
    }
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
int i = 1;
while (i <= 5) {
    System.out.println(i);
    i++;
}
</pre>

                    <h2>Lesson 4.3: Do-While Loop</h2>
                    <pre>
do {
    // runs at least once
} while (condition);
</pre>

                    <h3>Example:</h3>
                    <pre>
int i = 1;
do {
    System.out.println(i);
    i++;
} while (i <= 5);
</pre>

                    <h2>Lesson 4.4: For-Each Loop (Enhanced For)</h2>
                    <pre>
// Used to iterate over arrays and collections
int[] numbers = {10, 20, 30, 40, 50};
for (int num : numbers) {
    System.out.println(num);
}

String[] fruits = {"Apple", "Banana", "Cherry"};
for (String fruit : fruits) {
    System.out.println(fruit);
}
</pre>

                    <h3>Difference Between Loops:</h3>
                    <pre>
for loop      → when the number of iterations is known
while loop    → when iterations depend on a condition
do-while      → always runs at least once before checking
for-each      → when iterating over arrays or collections
</pre>

                    <h2>Lesson 4.5: Loop Control — break and continue</h2>
                    <pre>
break;    → exits the loop immediately
continue; → skips the rest of the current iteration
</pre>

                    <h3>Break Example:</h3>
                    <pre>
for (int i = 1; i <= 10; i++) {
    if (i == 5) break;
    System.out.println(i);
}
// Prints 1 2 3 4 then stops
</pre>

                    <h3>Continue Example:</h3>
                    <pre>
for (int i = 1; i <= 5; i++) {
    if (i == 3) continue;
    System.out.println(i);
}
// Prints 1 2 4 5 (skips 3)
</pre>

                    <h2>Lesson 4.6: Nested Loops and Star Patterns</h2>

                    <h3>Pattern 1 — Right Triangle:</h3>
                    <pre>
int n = 5;
for (int i = 1; i <= n; i++) {
    for (int j = 1; j <= i; j++) {
        System.out.print("* ");
    }
    System.out.println();
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

                    <h3>Pattern 2 — Square:</h3>
                    <pre>
int n = 4;
for (int i = 1; i <= n; i++) {
    for (int j = 1; j <= n; j++) {
        System.out.print("* ");
    }
    System.out.println();
}
</pre>
                    <h3>Output:</h3>
                    <pre>
* * * *
* * * *
* * * *
* * * *
</pre>

                    <form method="GET" action="{{ route('java.lesson4.quiz') }}">
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
                    <h2 id="lesson5">Lesson 5: Object-Oriented Programming (OOP)</h2>

                    <p>Object-Oriented Programming is the core paradigm of Java. The four pillars are: <b>Encapsulation</b>, <b>Inheritance</b>, <b>Polymorphism</b>, and <b>Abstraction</b>. Everything in Java is inside a class.</p>

                    <h3>Classes and Objects:</h3>
                    <pre>
// A class is a blueprint; an object is an instance of that blueprint.

public class Dog {
    // Fields (attributes)
    String name;
    int age;

    // Constructor — called when creating an object
    public Dog(String name, int age) {
        this.name = name;   // "this" refers to the current object
        this.age = age;
    }

    // Method (behavior)
    public void bark() {
        System.out.println(name + " says: Woof!");
    }
}

// Creating objects
public class Main {
    public static void main(String[] args) {
        Dog d1 = new Dog("Buddy", 3);
        Dog d2 = new Dog("Max", 5);

        d1.bark();   // Buddy says: Woof!
        d2.bark();   // Max says: Woof!

        System.out.println(d1.name + " is " + d1.age + " years old.");
    }
}
</pre>

                    <h3>Access Modifiers:</h3>
                    <pre>
public    → accessible from anywhere
private   → accessible only within the same class
protected → accessible within the class and subclasses
(default) → accessible within the same package (no keyword)
</pre>

                    <h3>Encapsulation — Getters and Setters:</h3>
                    <pre>
public class Person {
    private String name;   // private field
    private int age;

    // Getter
    public String getName() {
        return name;
    }

    // Setter
    public void setName(String name) {
        this.name = name;
    }

    public int getAge() { return age; }
    public void setAge(int age) {
        if (age >= 0) this.age = age;  // validation
    }
}
</pre>

                    <h3>Inheritance — extends:</h3>
                    <pre>
public class Animal {
    public void eat() {
        System.out.println("This animal eats food.");
    }
}

public class Cat extends Animal {
    public void meow() {
        System.out.println("Meow!");
    }
}

// Cat inherits eat() from Animal
Cat c = new Cat();
c.eat();    // This animal eats food.
c.meow();   // Meow!
</pre>

                    <h3>Polymorphism — Method Overriding:</h3>
                    <pre>
public class Animal {
    public void speak() {
        System.out.println("...");
    }
}

public class Dog extends Animal {
    @Override
    public void speak() {
        System.out.println("Woof!");
    }
}

public class Cat extends Animal {
    @Override
    public void speak() {
        System.out.println("Meow!");
    }
}

Animal a = new Dog();
a.speak();   // Woof!  (runs Dog's version)

Animal b = new Cat();
b.speak();   // Meow!  (runs Cat's version)
</pre>

                    <h3>Method Overloading (same name, different parameters):</h3>
                    <pre>
public class Calculator {
    public int add(int a, int b) {
        return a + b;
    }
    public double add(double a, double b) {
        return a + b;
    }
    public int add(int a, int b, int c) {
        return a + b + c;
    }
}
</pre>

                    <h3>static Keyword:</h3>
                    <pre>
public class MathUtils {
    public static int square(int n) {
        return n * n;
    }
}

// Called without creating an object:
int result = MathUtils.square(5);   // 25
</pre>

                    <h3>Abstract Classes and Interfaces:</h3>
                    <pre>
// Abstract class — cannot be instantiated directly
abstract class Shape {
    abstract double area();   // must be overridden by subclass

    public void describe() {
        System.out.println("I am a shape.");
    }
}

// Interface — a contract of methods a class must implement
interface Drawable {
    void draw();   // implicitly public and abstract
}

class Circle extends Shape implements Drawable {
    double radius;
    Circle(double r) { this.radius = r; }

    @Override
    public double area() { return Math.PI * radius * radius; }

    @Override
    public void draw() { System.out.println("Drawing circle."); }
}
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Use <code>@Override</code> annotation when overriding — it helps the compiler catch mistakes.</li>
                        <li>A class can <code>extend</code> only ONE class but <code>implement</code> multiple interfaces.</li>
                        <li>Use <code>super</code> to call the parent class's constructor or method.</li>
                        <li>Fields should generally be <code>private</code>; expose them through getters/setters (encapsulation).</li>
                    </ul>

                    <form method="GET" action="{{ route('java.lesson5.quiz') }}">
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
                    <form method="GET" action="{{ route('java.final.exam') }}">
                        <button>Take Final Exam</button>
                    </form>
                @endif

            @endif {{-- end !$showQuiz --}}


            {{-- ============================================================ --}}
            {{-- QUIZ SECTIONS                                                --}}
            {{-- ============================================================ --}}

            @if ($showQuiz === true)
                {{-- ── Lesson 1 Quiz ── --}}
                <h2>Lesson 1 Quiz — Introduction to Java</h2>
                <form method="POST" action="{{ route('java.submit') }}">
                    @csrf

                    <p>1. Who created the Java programming language?</p>
                    <input type="radio" name="q1" value="a"> A. Dennis Ritchie<br>
                    <input type="radio" name="q1" value="b"> B. James Gosling<br>
                    <input type="radio" name="q1" value="c"> C. Bjarne Stroustrup<br>
                    <input type="radio" name="q1" value="d"> D. Guido van Rossum<br><br>

                    <p>2. What does JVM stand for?</p>
                    <input type="radio" name="q2" value="a"> A. Java Variable Manager<br>
                    <input type="radio" name="q2" value="b"> B. Java Verified Module<br>
                    <input type="radio" name="q2" value="c"> C. Java Virtual Machine<br>
                    <input type="radio" name="q2" value="d"> D. Just Variable Memory<br><br>

                    <p>3. What is the correct file extension for a Java source file?</p>
                    <input type="radio" name="q3" value="a"> A. .py<br>
                    <input type="radio" name="q3" value="b"> B. .cpp<br>
                    <input type="radio" name="q3" value="c"> C. .c<br>
                    <input type="radio" name="q3" value="d"> D. .java<br><br>

                    <p>4. Which method is the entry point of every Java program?</p>
                    <input type="radio" name="q4" value="a"> A. public void start()<br>
                    <input type="radio" name="q4" value="b"> B. public static void main(String[] args)<br>
                    <input type="radio" name="q4" value="c"> C. static begin()<br>
                    <input type="radio" name="q4" value="d"> D. void run()<br><br>

                    <p>5. Which method prints output followed by a new line in Java?</p>
                    <input type="radio" name="q5" value="a"> A. System.out.print()<br>
                    <input type="radio" name="q5" value="b"> B. printf()<br>
                    <input type="radio" name="q5" value="c"> C. System.out.println()<br>
                    <input type="radio" name="q5" value="d"> D. Console.writeLine()<br><br>

                    <p>6. What does the "Write Once, Run Anywhere" principle mean?</p>
                    <input type="radio" name="q6" value="a"> A. Java code must be rewritten for each OS<br>
                    <input type="radio" name="q6" value="b"> B. Java compiles to bytecode that runs on any JVM<br>
                    <input type="radio" name="q6" value="c"> C. Java only runs on Windows<br>
                    <input type="radio" name="q6" value="d"> D. Java programs cannot be edited after compiling<br><br>

                    <p>7. Which escape sequence adds a new line in Java?</p>
                    <input type="radio" name="q7" value="a"> A. \t<br>
                    <input type="radio" name="q7" value="b"> B. \\<br>
                    <input type="radio" name="q7" value="c"> C. \n<br>
                    <input type="radio" name="q7" value="d"> D. \r<br><br>

                    <p>8. How do you write a single-line comment in Java?</p>
                    <input type="radio" name="q8" value="a"> A. # This is a comment<br>
                    <input type="radio" name="q8" value="b"> B. &lt;!-- This is a comment --&gt;<br>
                    <input type="radio" name="q8" value="c"> C. // This is a comment<br>
                    <input type="radio" name="q8" value="d"> D. /* This is a comment<br><br>

                    <p>9. Java is described as which type of language?</p>
                    <input type="radio" name="q9" value="a"> A. Procedural only<br>
                    <input type="radio" name="q9" value="b"> B. Object-Oriented<br>
                    <input type="radio" name="q9" value="c"> C. Functional only<br>
                    <input type="radio" name="q9" value="d"> D. Assembly-based<br><br>

                    <p>10. What does \t represent in a Java string?</p>
                    <input type="radio" name="q10" value="a"> A. New line<br>
                    <input type="radio" name="q10" value="b"> B. Tab space<br>
                    <input type="radio" name="q10" value="c"> C. Backslash<br>
                    <input type="radio" name="q10" value="d"> D. End of string<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson2')
                {{-- ── Lesson 2 Quiz ── --}}
                <h2>Lesson 2 Quiz — Data Types and Variables</h2>
                <form method="POST" action="{{ route('java.lesson2.submit') }}">
                    @csrf

                    <p>1. Which data type stores whole numbers in Java?</p>
                    <input type="radio" name="q1" value="a"> A. double<br>
                    <input type="radio" name="q1" value="b"> B. char<br>
                    <input type="radio" name="q1" value="c"> C. int<br>
                    <input type="radio" name="q1" value="d"> D. boolean<br><br>

                    <p>2. Which data type stores true or false?</p>
                    <input type="radio" name="q2" value="a"> A. int<br>
                    <input type="radio" name="q2" value="b"> B. boolean<br>
                    <input type="radio" name="q2" value="c"> C. char<br>
                    <input type="radio" name="q2" value="d"> D. String<br><br>

                    <p>3. What keyword makes a variable a constant in Java?</p>
                    <input type="radio" name="q3" value="a"> A. const<br>
                    <input type="radio" name="q3" value="b"> B. static<br>
                    <input type="radio" name="q3" value="c"> C. final<br>
                    <input type="radio" name="q3" value="d"> D. immutable<br><br>

                    <p>4. Which class is used to read user input in Java?</p>
                    <input type="radio" name="q4" value="a"> A. BufferedReader<br>
                    <input type="radio" name="q4" value="b"> B. System<br>
                    <input type="radio" name="q4" value="c"> C. Scanner<br>
                    <input type="radio" name="q4" value="d"> D. Input<br><br>

                    <p>5. What is the format specifier for a double in printf?</p>
                    <input type="radio" name="q5" value="a"> A. %d<br>
                    <input type="radio" name="q5" value="b"> B. %c<br>
                    <input type="radio" name="q5" value="c"> C. %s<br>
                    <input type="radio" name="q5" value="d"> D. %f<br><br>

                    <p>6. What is the result of (int) 3.9 in Java?</p>
                    <input type="radio" name="q6" value="a"> A. 4<br>
                    <input type="radio" name="q6" value="b"> B. 3<br>
                    <input type="radio" name="q6" value="c"> C. 3.9<br>
                    <input type="radio" name="q6" value="d"> D. Error<br><br>

                    <p>7. Which is NOT a primitive data type in Java?</p>
                    <input type="radio" name="q7" value="a"> A. int<br>
                    <input type="radio" name="q7" value="b"> B. float<br>
                    <input type="radio" name="q7" value="c"> C. String<br>
                    <input type="radio" name="q7" value="d"> D. char<br><br>

                    <p>8. How should you compare two Strings in Java?</p>
                    <input type="radio" name="q8" value="a"> A. Using ==<br>
                    <input type="radio" name="q8" value="b"> B. Using .equals()<br>
                    <input type="radio" name="q8" value="c"> C. Using ===<br>
                    <input type="radio" name="q8" value="d"> D. Using .compare()<br><br>

                    <p>9. Which Scanner method reads a full line of text?</p>
                    <input type="radio" name="q9" value="a"> A. sc.nextInt()<br>
                    <input type="radio" name="q9" value="b"> B. sc.next()<br>
                    <input type="radio" name="q9" value="c"> C. sc.nextLine()<br>
                    <input type="radio" name="q9" value="d"> D. sc.readLine()<br><br>

                    <p>10. What does %.2f display in printf?</p>
                    <input type="radio" name="q10" value="a"> A. An integer<br>
                    <input type="radio" name="q10" value="b"> B. A float with 2 decimal places<br>
                    <input type="radio" name="q10" value="c"> C. A character<br>
                    <input type="radio" name="q10" value="d"> D. A boolean<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson3')
                {{-- ── Lesson 3 Quiz ── --}}
                <h2>Lesson 3 Quiz — Control Flow</h2>
                <form method="POST" action="{{ route('java.lesson3.submit') }}">
                    @csrf

                    <p>1. Which operator checks equality in Java?</p>
                    <input type="radio" name="q1" value="a"> A. =<br>
                    <input type="radio" name="q1" value="b"> B. ===<br>
                    <input type="radio" name="q1" value="c"> C. ==<br>
                    <input type="radio" name="q1" value="d"> D. !=<br><br>

                    <p>2. What does the && operator mean in Java?</p>
                    <input type="radio" name="q2" value="a"> A. OR<br>
                    <input type="radio" name="q2" value="b"> B. NOT<br>
                    <input type="radio" name="q2" value="c"> C. AND<br>
                    <input type="radio" name="q2" value="d"> D. XOR<br><br>

                    <p>3. What does || mean in Java?</p>
                    <input type="radio" name="q3" value="a"> A. AND<br>
                    <input type="radio" name="q3" value="b"> B. NOT<br>
                    <input type="radio" name="q3" value="c"> C. EQUAL<br>
                    <input type="radio" name="q3" value="d"> D. OR<br><br>

                    <p>4. Which data type CANNOT be used in a Java switch statement?</p>
                    <input type="radio" name="q4" value="a"> A. int<br>
                    <input type="radio" name="q4" value="b"> B. char<br>
                    <input type="radio" name="q4" value="c"> C. double<br>
                    <input type="radio" name="q4" value="d"> D. String<br><br>

                    <p>5. What keyword prevents fall-through in a switch statement?</p>
                    <input type="radio" name="q5" value="a"> A. stop<br>
                    <input type="radio" name="q5" value="b"> B. end<br>
                    <input type="radio" name="q5" value="c"> C. exit<br>
                    <input type="radio" name="q5" value="d"> D. break<br><br>

                    <p>6. What is the correct syntax for an if statement in Java?</p>
                    <input type="radio" name="q6" value="a"> A. if condition { }<br>
                    <input type="radio" name="q6" value="b"> B. if [condition] { }<br>
                    <input type="radio" name="q6" value="c"> C. if (condition) { }<br>
                    <input type="radio" name="q6" value="d"> D. if &lt;condition&gt; { }<br><br>

                    <p>7. What does the ternary operator return for: (5 > 3) ? "Yes" : "No"?</p>
                    <input type="radio" name="q7" value="a"> A. No<br>
                    <input type="radio" name="q7" value="b"> B. null<br>
                    <input type="radio" name="q7" value="c"> C. Yes<br>
                    <input type="radio" name="q7" value="d"> D. Error<br><br>

                    <p>8. What does != mean?</p>
                    <input type="radio" name="q8" value="a"> A. Equal to<br>
                    <input type="radio" name="q8" value="b"> B. Greater than<br>
                    <input type="radio" name="q8" value="c"> C. Not equal to<br>
                    <input type="radio" name="q8" value="d"> D. Less than<br><br>

                    <p>9. The default case in switch runs when?</p>
                    <input type="radio" name="q9" value="a"> A. The first case matches<br>
                    <input type="radio" name="q9" value="b"> B. No case matches<br>
                    <input type="radio" name="q9" value="c"> C. Every time<br>
                    <input type="radio" name="q9" value="d"> D. After break<br><br>

                    <p>10. The ! operator in Java is used for?</p>
                    <input type="radio" name="q10" value="a"> A. Multiplication<br>
                    <input type="radio" name="q10" value="b"> B. Division<br>
                    <input type="radio" name="q10" value="c"> C. Logical NOT<br>
                    <input type="radio" name="q10" value="d"> D. Modulus<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson4')
                {{-- ── Lesson 4 Quiz ── --}}
                <h2>Lesson 4 Quiz — Loops</h2>
                <form method="POST" action="{{ route('java.lesson4.submit') }}">
                    @csrf

                    <p>1. Which loop is best when the number of iterations is known?</p>
                    <input type="radio" name="q1" value="a"> A. while<br>
                    <input type="radio" name="q1" value="b"> B. do-while<br>
                    <input type="radio" name="q1" value="c"> C. for<br>
                    <input type="radio" name="q1" value="d"> D. switch<br><br>

                    <p>2. What is the correct syntax of a for loop in Java?</p>
                    <input type="radio" name="q2" value="a"> A. for (init, condition, update)<br>
                    <input type="radio" name="q2" value="b"> B. for [init; condition; update]<br>
                    <input type="radio" name="q2" value="c"> C. for (init; condition; update)<br>
                    <input type="radio" name="q2" value="d"> D. loop (init; condition; update)<br><br>

                    <p>3. Which keyword immediately exits a loop in Java?</p>
                    <input type="radio" name="q3" value="a"> A. exit<br>
                    <input type="radio" name="q3" value="b"> B. stop<br>
                    <input type="radio" name="q3" value="c"> C. return<br>
                    <input type="radio" name="q3" value="d"> D. break<br><br>

                    <p>4. Which keyword skips the current iteration of a loop?</p>
                    <input type="radio" name="q4" value="a"> A. skip<br>
                    <input type="radio" name="q4" value="b"> B. next<br>
                    <input type="radio" name="q4" value="c"> C. continue<br>
                    <input type="radio" name="q4" value="d"> D. pass<br><br>

                    <p>5. Which loop always executes its body at least once?</p>
                    <input type="radio" name="q5" value="a"> A. for<br>
                    <input type="radio" name="q5" value="b"> B. while<br>
                    <input type="radio" name="q5" value="c"> C. do-while<br>
                    <input type="radio" name="q5" value="d"> D. for-each<br><br>

                    <p>6. How many times does for(int i=0; i&lt;5; i++) execute?</p>
                    <input type="radio" name="q6" value="a"> A. 4<br>
                    <input type="radio" name="q6" value="b"> B. 6<br>
                    <input type="radio" name="q6" value="c"> C. 5<br>
                    <input type="radio" name="q6" value="d"> D. Infinite<br><br>

                    <p>7. What is a nested loop?</p>
                    <input type="radio" name="q7" value="a"> A. A loop with no condition<br>
                    <input type="radio" name="q7" value="b"> B. A loop inside another loop<br>
                    <input type="radio" name="q7" value="c"> C. A loop that runs once<br>
                    <input type="radio" name="q7" value="d"> D. A loop with break<br><br>

                    <p>8. Which loop is best for iterating over an array in Java?</p>
                    <input type="radio" name="q8" value="a"> A. while<br>
                    <input type="radio" name="q8" value="b"> B. do-while<br>
                    <input type="radio" name="q8" value="c"> C. for-each (enhanced for)<br>
                    <input type="radio" name="q8" value="d"> D. switch<br><br>

                    <p>9. What does i++ mean in a Java loop?</p>
                    <input type="radio" name="q9" value="a"> A. Decrease i by 1<br>
                    <input type="radio" name="q9" value="b"> B. Reset i to 0<br>
                    <input type="radio" name="q9" value="c"> C. Multiply i by 2<br>
                    <input type="radio" name="q9" value="d"> D. Increase i by 1<br><br>

                    <p>10. What is the correct for-each syntax to iterate an int array called nums?</p>
                    <input type="radio" name="q10" value="a"> A. for (nums : int n)<br>
                    <input type="radio" name="q10" value="b"> B. foreach (int n in nums)<br>
                    <input type="radio" name="q10" value="c"> C. for (int n : nums)<br>
                    <input type="radio" name="q10" value="d"> D. for (int n; nums)<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson5')
                {{-- ── Lesson 5 Quiz ── --}}
                <h2>Lesson 5 Quiz — Object-Oriented Programming</h2>
                <form method="POST" action="{{ route('java.lesson5.submit') }}">
                    @csrf

                    <p>1. What is a class in Java?</p>
                    <input type="radio" name="q1" value="a"> A. A variable<br>
                    <input type="radio" name="q1" value="b"> B. A blueprint for creating objects<br>
                    <input type="radio" name="q1" value="c"> C. A loop structure<br>
                    <input type="radio" name="q1" value="d"> D. A method<br><br>

                    <p>2. What keyword is used to create an object in Java?</p>
                    <input type="radio" name="q2" value="a"> A. create<br>
                    <input type="radio" name="q2" value="b"> B. object<br>
                    <input type="radio" name="q2" value="c"> C. new<br>
                    <input type="radio" name="q2" value="d"> D. make<br><br>

                    <p>3. What does the "this" keyword refer to in Java?</p>
                    <input type="radio" name="q3" value="a"> A. The parent class<br>
                    <input type="radio" name="q3" value="b"> B. A static reference<br>
                    <input type="radio" name="q3" value="c"> C. The current object instance<br>
                    <input type="radio" name="q3" value="d"> D. The main class<br><br>

                    <p>4. Which access modifier makes a member visible only within its class?</p>
                    <input type="radio" name="q4" value="a"> A. public<br>
                    <input type="radio" name="q4" value="b"> B. protected<br>
                    <input type="radio" name="q4" value="c"> C. private<br>
                    <input type="radio" name="q4" value="d"> D. default<br><br>

                    <p>5. Which keyword is used to inherit from a class in Java?</p>
                    <input type="radio" name="q5" value="a"> A. implements<br>
                    <input type="radio" name="q5" value="b"> B. inherits<br>
                    <input type="radio" name="q5" value="c"> C. super<br>
                    <input type="radio" name="q5" value="d"> D. extends<br><br>

                    <p>6. What annotation signals that a method overrides a parent method?</p>
                    <input type="radio" name="q6" value="a"> A. @Override<br>
                    <input type="radio" name="q6" value="b"> B. @Inherit<br>
                    <input type="radio" name="q6" value="c"> C. @Super<br>
                    <input type="radio" name="q6" value="d"> D. @Extend<br><br>

                    <p>7. Encapsulation in Java is achieved by:</p>
                    <input type="radio" name="q7" value="a"> A. Making all fields public<br>
                    <input type="radio" name="q7" value="b"> B. Making fields private and using getters/setters<br>
                    <input type="radio" name="q7" value="c"> C. Using static methods only<br>
                    <input type="radio" name="q7" value="d"> D. Extending classes<br><br>

                    <p>8. What is method overloading?</p>
                    <input type="radio" name="q8" value="a"> A. A method calling itself<br>
                    <input type="radio" name="q8" value="b"> B. A child class replacing a parent method<br>
                    <input type="radio" name="q8" value="c"> C. Multiple methods with the same name but different parameters<br>
                    <input type="radio" name="q8" value="d"> D. A method with no return type<br><br>

                    <p>9. How many classes can a Java class extend?</p>
                    <input type="radio" name="q9" value="a"> A. Unlimited<br>
                    <input type="radio" name="q9" value="b"> B. Only one<br>
                    <input type="radio" name="q9" value="c"> C. Two<br>
                    <input type="radio" name="q9" value="d"> D. Three<br><br>

                    <p>10. What keyword is used to call the parent class constructor?</p>
                    <input type="radio" name="q10" value="a"> A. parent<br>
                    <input type="radio" name="q10" value="b"> B. base<br>
                    <input type="radio" name="q10" value="c"> C. super<br>
                    <input type="radio" name="q10" value="d"> D. this<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'final')
                {{-- ── Final Exam (50 questions) ── --}}
                <h2>🎓 Java Programming Final Exam</h2>
                <p>This exam covers all lessons. Answer all 50 questions.</p>

                <form method="POST" action="{{ route('java.final.submit') }}">
                    @csrf

                    <h3>— Introduction to Java (Q1–10) —</h3>

                    <p>1. Who created Java?</p>
                    <input type="radio" name="q1" value="a"> A. Dennis Ritchie<br>
                    <input type="radio" name="q1" value="b"> B. Bjarne Stroustrup<br>
                    <input type="radio" name="q1" value="c"> C. James Gosling<br>
                    <input type="radio" name="q1" value="d"> D. Guido van Rossum<br><br>

                    <p>2. Java was created in what year?</p>
                    <input type="radio" name="q2" value="a"> A. 1972<br>
                    <input type="radio" name="q2" value="b"> B. 1983<br>
                    <input type="radio" name="q2" value="c"> C. 1991<br>
                    <input type="radio" name="q2" value="d"> D. 1995<br><br>

                    <p>3. What does JVM stand for?</p>
                    <input type="radio" name="q3" value="a"> A. Java Variable Manager<br>
                    <input type="radio" name="q3" value="b"> B. Java Virtual Machine<br>
                    <input type="radio" name="q3" value="c"> C. Java Verified Module<br>
                    <input type="radio" name="q3" value="d"> D. Just Variable Memory<br><br>

                    <p>4. What is the correct file extension for a Java source file?</p>
                    <input type="radio" name="q4" value="a"> A. .class<br>
                    <input type="radio" name="q4" value="b"> B. .py<br>
                    <input type="radio" name="q4" value="c"> C. .java<br>
                    <input type="radio" name="q4" value="d"> D. .cpp<br><br>

                    <p>5. Which method is the entry point of a Java program?</p>
                    <input type="radio" name="q5" value="a"> A. public void start()<br>
                    <input type="radio" name="q5" value="b"> B. static begin()<br>
                    <input type="radio" name="q5" value="c"> C. void run()<br>
                    <input type="radio" name="q5" value="d"> D. public static void main(String[] args)<br><br>

                    <p>6. Which method prints output with a new line in Java?</p>
                    <input type="radio" name="q6" value="a"> A. System.out.print()<br>
                    <input type="radio" name="q6" value="b"> B. System.out.println()<br>
                    <input type="radio" name="q6" value="c"> C. Console.write()<br>
                    <input type="radio" name="q6" value="d"> D. printf()<br><br>

                    <p>7. What does \n do in a Java string?</p>
                    <input type="radio" name="q7" value="a"> A. Tab<br>
                    <input type="radio" name="q7" value="b"> B. Backslash<br>
                    <input type="radio" name="q7" value="c"> C. Newline<br>
                    <input type="radio" name="q7" value="d"> D. Space<br><br>

                    <p>8. How is a single-line comment written in Java?</p>
                    <input type="radio" name="q8" value="a"> A. # comment<br>
                    <input type="radio" name="q8" value="b"> B. // comment<br>
                    <input type="radio" name="q8" value="c"> C. &lt;!-- comment --&gt;<br>
                    <input type="radio" name="q8" value="d"> D. /* comment<br><br>

                    <p>9. Java is described as which type of language?</p>
                    <input type="radio" name="q9" value="a"> A. Procedural only<br>
                    <input type="radio" name="q9" value="b"> B. Functional only<br>
                    <input type="radio" name="q9" value="c"> C. Object-Oriented<br>
                    <input type="radio" name="q9" value="d"> D. Assembly-based<br><br>

                    <p>10. What does \t represent in a Java string?</p>
                    <input type="radio" name="q10" value="a"> A. New line<br>
                    <input type="radio" name="q10" value="b"> B. End of string<br>
                    <input type="radio" name="q10" value="c"> C. Backslash<br>
                    <input type="radio" name="q10" value="d"> D. Tab space<br><br>

                    <h3>— Data Types &amp; Variables (Q11–20) —</h3>

                    <p>11. Which data type stores whole numbers in Java?</p>
                    <input type="radio" name="q11" value="a"> A. double<br>
                    <input type="radio" name="q11" value="b"> B. char<br>
                    <input type="radio" name="q11" value="c"> C. int<br>
                    <input type="radio" name="q11" value="d"> D. boolean<br><br>

                    <p>12. Which data type stores a single character?</p>
                    <input type="radio" name="q12" value="a"> A. String<br>
                    <input type="radio" name="q12" value="b"> B. int<br>
                    <input type="radio" name="q12" value="c"> C. char<br>
                    <input type="radio" name="q12" value="d"> D. byte<br><br>

                    <p>13. What keyword creates a constant in Java?</p>
                    <input type="radio" name="q13" value="a"> A. const<br>
                    <input type="radio" name="q13" value="b"> B. final<br>
                    <input type="radio" name="q13" value="c"> C. static<br>
                    <input type="radio" name="q13" value="d"> D. immutable<br><br>

                    <p>14. Which class reads user input in Java?</p>
                    <input type="radio" name="q14" value="a"> A. System<br>
                    <input type="radio" name="q14" value="b"> B. Input<br>
                    <input type="radio" name="q14" value="c"> C. Scanner<br>
                    <input type="radio" name="q14" value="d"> D. Reader<br><br>

                    <p>15. What does %.2f display in printf?</p>
                    <input type="radio" name="q15" value="a"> A. An integer<br>
                    <input type="radio" name="q15" value="b"> B. A float with 2 decimal places<br>
                    <input type="radio" name="q15" value="c"> C. A character<br>
                    <input type="radio" name="q15" value="d"> D. A boolean<br><br>

                    <p>16. Which is NOT a primitive type in Java?</p>
                    <input type="radio" name="q16" value="a"> A. int<br>
                    <input type="radio" name="q16" value="b"> B. float<br>
                    <input type="radio" name="q16" value="c"> C. String<br>
                    <input type="radio" name="q16" value="d"> D. char<br><br>

                    <p>17. What is the result of (int) 3.9 in Java?</p>
                    <input type="radio" name="q17" value="a"> A. 4<br>
                    <input type="radio" name="q17" value="b"> B. 3<br>
                    <input type="radio" name="q17" value="c"> C. 3.9<br>
                    <input type="radio" name="q17" value="d"> D. Error<br><br>

                    <p>18. How should two Strings be compared in Java?</p>
                    <input type="radio" name="q18" value="a"> A. Using ==<br>
                    <input type="radio" name="q18" value="b"> B. Using .equals()<br>
                    <input type="radio" name="q18" value="c"> C. Using ===<br>
                    <input type="radio" name="q18" value="d"> D. Using .compare()<br><br>

                    <p>19. Which Scanner method reads a full line of text?</p>
                    <input type="radio" name="q19" value="a"> A. sc.nextInt()<br>
                    <input type="radio" name="q19" value="b"> B. sc.next()<br>
                    <input type="radio" name="q19" value="c"> C. sc.readLine()<br>
                    <input type="radio" name="q19" value="d"> D. sc.nextLine()<br><br>

                    <p>20. Which converts a String "42" to an int?</p>
                    <input type="radio" name="q20" value="a"> A. (int) "42"<br>
                    <input type="radio" name="q20" value="b"> B. Integer.parseInt("42")<br>
                    <input type="radio" name="q20" value="c"> C. String.toInt("42")<br>
                    <input type="radio" name="q20" value="d"> D. Convert.toInt("42")<br><br>

                    <h3>— Control Flow (Q21–30) —</h3>

                    <p>21. Which operator checks equality in Java?</p>
                    <input type="radio" name="q21" value="a"> A. =<br>
                    <input type="radio" name="q21" value="b"> B. ==<br>
                    <input type="radio" name="q21" value="c"> C. ===<br>
                    <input type="radio" name="q21" value="d"> D. !=<br><br>

                    <p>22. What does && mean?</p>
                    <input type="radio" name="q22" value="a"> A. OR<br>
                    <input type="radio" name="q22" value="b"> B. NOT<br>
                    <input type="radio" name="q22" value="c"> C. AND<br>
                    <input type="radio" name="q22" value="d"> D. XOR<br><br>

                    <p>23. What does || mean?</p>
                    <input type="radio" name="q23" value="a"> A. AND<br>
                    <input type="radio" name="q23" value="b"> B. OR<br>
                    <input type="radio" name="q23" value="c"> C. NOT<br>
                    <input type="radio" name="q23" value="d"> D. EQUAL<br><br>

                    <p>24. Which type CANNOT be used in a Java switch?</p>
                    <input type="radio" name="q24" value="a"> A. int<br>
                    <input type="radio" name="q24" value="b"> B. char<br>
                    <input type="radio" name="q24" value="c"> C. double<br>
                    <input type="radio" name="q24" value="d"> D. String<br><br>

                    <p>25. What does != mean?</p>
                    <input type="radio" name="q25" value="a"> A. Equal to<br>
                    <input type="radio" name="q25" value="b"> B. Greater than<br>
                    <input type="radio" name="q25" value="c"> C. Not equal to<br>
                    <input type="radio" name="q25" value="d"> D. Less than<br><br>

                    <p>26. What keyword prevents fall-through in switch?</p>
                    <input type="radio" name="q26" value="a"> A. stop<br>
                    <input type="radio" name="q26" value="b"> B. end<br>
                    <input type="radio" name="q26" value="c"> C. break<br>
                    <input type="radio" name="q26" value="d"> D. exit<br><br>

                    <p>27. The ! operator in Java means?</p>
                    <input type="radio" name="q27" value="a"> A. Multiply<br>
                    <input type="radio" name="q27" value="b"> B. Divide<br>
                    <input type="radio" name="q27" value="c"> C. Logical NOT<br>
                    <input type="radio" name="q27" value="d"> D. Modulus<br><br>

                    <p>28. What does (age >= 18) ? "Adult" : "Minor" return if age = 16?</p>
                    <input type="radio" name="q28" value="a"> A. Adult<br>
                    <input type="radio" name="q28" value="b"> B. null<br>
                    <input type="radio" name="q28" value="c"> C. Error<br>
                    <input type="radio" name="q28" value="d"> D. Minor<br><br>

                    <p>29. If condition is false and there is no else block?</p>
                    <input type="radio" name="q29" value="a"> A. Program crashes<br>
                    <input type="radio" name="q29" value="b"> B. If block runs<br>
                    <input type="radio" name="q29" value="c"> C. Nothing, program continues<br>
                    <input type="radio" name="q29" value="d"> D. Error thrown<br><br>

                    <p>30. Which operator means "greater than or equal to"?</p>
                    <input type="radio" name="q30" value="a"> A. &lt;=<br>
                    <input type="radio" name="q30" value="b"> B. ==<br>
                    <input type="radio" name="q30" value="c"> C. !=<br>
                    <input type="radio" name="q30" value="d"> D. >=<br><br>

                    <h3>— Loops (Q31–40) —</h3>

                    <p>31. Best loop when iterations are known?</p>
                    <input type="radio" name="q31" value="a"> A. while<br>
                    <input type="radio" name="q31" value="b"> B. do-while<br>
                    <input type="radio" name="q31" value="c"> C. for<br>
                    <input type="radio" name="q31" value="d"> D. switch<br><br>

                    <p>32. Which loop runs at least once?</p>
                    <input type="radio" name="q32" value="a"> A. for<br>
                    <input type="radio" name="q32" value="b"> B. while<br>
                    <input type="radio" name="q32" value="c"> C. do-while<br>
                    <input type="radio" name="q32" value="d"> D. for-each<br><br>

                    <p>33. Keyword to exit a loop immediately?</p>
                    <input type="radio" name="q33" value="a"> A. exit<br>
                    <input type="radio" name="q33" value="b"> B. stop<br>
                    <input type="radio" name="q33" value="c"> C. break<br>
                    <input type="radio" name="q33" value="d"> D. return<br><br>

                    <p>34. Keyword to skip the current iteration?</p>
                    <input type="radio" name="q34" value="a"> A. skip<br>
                    <input type="radio" name="q34" value="b"> B. next<br>
                    <input type="radio" name="q34" value="c"> C. continue<br>
                    <input type="radio" name="q34" value="d"> D. pass<br><br>

                    <p>35. How many times does for(int i=0; i&lt;5; i++) run?</p>
                    <input type="radio" name="q35" value="a"> A. 4<br>
                    <input type="radio" name="q35" value="b"> B. 6<br>
                    <input type="radio" name="q35" value="c"> C. 5<br>
                    <input type="radio" name="q35" value="d"> D. Infinite<br><br>

                    <p>36. A loop inside another loop is called?</p>
                    <input type="radio" name="q36" value="a"> A. Double loop<br>
                    <input type="radio" name="q36" value="b"> B. Nested loop<br>
                    <input type="radio" name="q36" value="c"> C. Inner loop<br>
                    <input type="radio" name="q36" value="d"> D. Super loop<br><br>

                    <p>37. Which loop checks condition AFTER the body?</p>
                    <input type="radio" name="q37" value="a"> A. for<br>
                    <input type="radio" name="q37" value="b"> B. while<br>
                    <input type="radio" name="q37" value="c"> C. do-while<br>
                    <input type="radio" name="q37" value="d"> D. switch<br><br>

                    <p>38. What does i++ do?</p>
                    <input type="radio" name="q38" value="a"> A. Decrease i by 1<br>
                    <input type="radio" name="q38" value="b"> B. Reset i to 0<br>
                    <input type="radio" name="q38" value="c"> C. Multiply i by 2<br>
                    <input type="radio" name="q38" value="d"> D. Increase i by 1<br><br>

                    <p>39. The for-each loop is best used for?</p>
                    <input type="radio" name="q39" value="a"> A. Counting specific iterations<br>
                    <input type="radio" name="q39" value="b"> B. Iterating over arrays and collections<br>
                    <input type="radio" name="q39" value="c"> C. Running code at least once<br>
                    <input type="radio" name="q39" value="d"> D. Decision making<br><br>

                    <p>40. What is the correct for-each syntax for an array "nums"?</p>
                    <input type="radio" name="q40" value="a"> A. for (nums : int n)<br>
                    <input type="radio" name="q40" value="b"> B. foreach (int n in nums)<br>
                    <input type="radio" name="q40" value="c"> C. for (int n : nums)<br>
                    <input type="radio" name="q40" value="d"> D. for each (int n, nums)<br><br>

                    <h3>— Object-Oriented Programming (Q41–50) —</h3>

                    <p>41. What is a class in Java?</p>
                    <input type="radio" name="q41" value="a"> A. A variable<br>
                    <input type="radio" name="q41" value="b"> B. A loop structure<br>
                    <input type="radio" name="q41" value="c"> C. A blueprint for creating objects<br>
                    <input type="radio" name="q41" value="d"> D. A method<br><br>

                    <p>42. What keyword creates an object in Java?</p>
                    <input type="radio" name="q42" value="a"> A. create<br>
                    <input type="radio" name="q42" value="b"> B. new<br>
                    <input type="radio" name="q42" value="c"> C. object<br>
                    <input type="radio" name="q42" value="d"> D. make<br><br>

                    <p>43. What does the "this" keyword refer to?</p>
                    <input type="radio" name="q43" value="a"> A. The parent class<br>
                    <input type="radio" name="q43" value="b"> B. A static reference<br>
                    <input type="radio" name="q43" value="c"> C. The current object instance<br>
                    <input type="radio" name="q43" value="d"> D. The main class<br><br>

                    <p>44. Which access modifier makes a member visible only within its class?</p>
                    <input type="radio" name="q44" value="a"> A. public<br>
                    <input type="radio" name="q44" value="b"> B. protected<br>
                    <input type="radio" name="q44" value="c"> C. private<br>
                    <input type="radio" name="q44" value="d"> D. default<br><br>

                    <p>45. Which keyword is used to inherit from a class?</p>
                    <input type="radio" name="q45" value="a"> A. implements<br>
                    <input type="radio" name="q45" value="b"> B. inherits<br>
                    <input type="radio" name="q45" value="c"> C. extends<br>
                    <input type="radio" name="q45" value="d"> D. super<br><br>

                    <p>46. Which annotation marks a method as overriding a parent method?</p>
                    <input type="radio" name="q46" value="a"> A. @Override<br>
                    <input type="radio" name="q46" value="b"> B. @Inherit<br>
                    <input type="radio" name="q46" value="c"> C. @Super<br>
                    <input type="radio" name="q46" value="d"> D. @Extend<br><br>

                    <p>47. What is method overloading?</p>
                    <input type="radio" name="q47" value="a"> A. A method calling itself<br>
                    <input type="radio" name="q47" value="b"> B. A child class replacing a parent method<br>
                    <input type="radio" name="q47" value="c"> C. Multiple methods with the same name but different parameters<br>
                    <input type="radio" name="q47" value="d"> D. A method with no return type<br><br>

                    <p>48. How many classes can a Java class extend at once?</p>
                    <input type="radio" name="q48" value="a"> A. Unlimited<br>
                    <input type="radio" name="q48" value="b"> B. Two<br>
                    <input type="radio" name="q48" value="c"> C. Only one<br>
                    <input type="radio" name="q48" value="d"> D. Three<br><br>

                    <p>49. Encapsulation is achieved by?</p>
                    <input type="radio" name="q49" value="a"> A. Making all fields public<br>
                    <input type="radio" name="q49" value="b"> B. Making fields private with getters and setters<br>
                    <input type="radio" name="q49" value="c"> C. Using static methods only<br>
                    <input type="radio" name="q49" value="d"> D. Extending classes<br><br>

                    <p>50. What is polymorphism in Java?</p>
                    <input type="radio" name="q50" value="a"> A. A class with no methods<br>
                    <input type="radio" name="q50" value="b"> B. One interface with many implementations (method overriding)<br>
                    <input type="radio" name="q50" value="c"> C. A loop that changes type<br>
                    <input type="radio" name="q50" value="d"> D. Making a variable constant<br><br>

                    <button type="submit">Submit Final Exam</button>
                </form>

            @endif {{-- end quiz sections --}}

        </div>
    </div>

</body>
</html>
