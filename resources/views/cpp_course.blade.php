<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C++ Programming Course</title>
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
                            'cpp_lesson1' => route('cpp.course') . '#lesson2',
                            'cpp_lesson2' => route('cpp.course') . '#lesson3',
                            'cpp_lesson3' => route('cpp.course') . '#lesson4',
                            'cpp_lesson4' => route('cpp.course') . '#lesson5',
                            'cpp_lesson5' => route('cpp.course') . '#final',
                            'cpp_final'   => route('dashboard'),
                            default       => route('cpp.course'),
                        };
                        $nextLabel = session('quiz') === 'cpp_final' ? 'Back to Dashboard' : 'Proceed to Next Lesson →';
                    @endphp
                    <a href="{{ $nextRoute }}">
                        <button type="button">{{ $nextLabel }}</button>
                    </a>
                @else
                    @php
                        $retakeRoute = match(session('quiz')) {
                            'cpp_lesson1' => route('cpp.quiz'),
                            'cpp_lesson2' => route('cpp.lesson2.quiz'),
                            'cpp_lesson3' => route('cpp.lesson3.quiz'),
                            'cpp_lesson4' => route('cpp.lesson4.quiz'),
                            'cpp_lesson5' => route('cpp.lesson5.quiz'),
                            'cpp_final'   => route('cpp.final.exam'),
                            default       => route('cpp.quiz'),
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
                    <button type="button">View C++ Certificate</button>
                </a>
            </div>
        @endif

        <div class="lesson-box">

            {{-- ============================================================ --}}
            {{-- LESSON CONTENT                                               --}}
            {{-- ============================================================ --}}
            @if (!$showQuiz)

                {{-- ── LESSON 1 ── --}}
                <h2>Lesson 1: Introduction to C++</h2>

                <p><b>C++</b> is a general-purpose programming language created by <b>Bjarne Stroustrup</b> in 1983 as an extension of the C language. It adds <b>object-oriented programming (OOP)</b> features to C while keeping C's speed and low-level capabilities. C++ is widely used in game development, system software, embedded systems, and high-performance applications.</p>

                <h3>Why Learn C++?</h3>
                <ul>
                    <li>Fast and powerful — close to hardware like C</li>
                    <li>Supports both procedural and object-oriented programming</li>
                    <li>Used in game engines (Unreal Engine), operating systems, and browsers</li>
                    <li>Foundation for understanding modern languages like C# and Java</li>
                    <li>Large standard library (STL) with ready-made data structures</li>
                </ul>

                <h3>Basic Structure of a C++ Program:</h3>
                <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    cout &lt;&lt; "Hello, World!" &lt;&lt; endl;
    return 0;
}
</pre>

                <h3>Explanation of Each Part:</h3>
                <pre>
#include &lt;iostream&gt;
Preprocessor directive that includes the Input/Output stream library.
Required for cout (output) and cin (input).

using namespace std;
Tells the compiler to use the standard namespace.
Without it, you'd need to write std::cout and std::cin every time.

int main()
The entry point of every C++ program.
Returns an integer — 0 means success.

{
Opening curly brace — starts the function body.

    cout &lt;&lt; "Hello, World!" &lt;&lt; endl;
cout   → character output stream (prints to screen)
&lt;&lt;     → insertion operator (sends data to cout)
endl   → end line (moves cursor to next line, also flushes buffer)
"\n"   → also moves to next line (faster than endl)

    return 0;
Signals successful program termination to the OS.

}
Closing curly brace — ends the function body.
</pre>

                <h3>Important Notes:</h3>
                <ul>
                    <li>Every C++ program must have a <code>main()</code> function.</li>
                    <li>Statements end with a semicolon <code>;</code></li>
                    <li>C++ is <strong>case-sensitive</strong> — <code>Main</code> and <code>main</code> are different.</li>
                    <li>Use <code>//</code> for single-line comments and <code>/* */</code> for multi-line comments.</li>
                    <li>Compile with: <code>g++ hello.cpp -o hello</code> then run: <code>./hello</code></li>
                </ul>

                <h2>Lesson 1.1: Comments and Basic Output</h2>

                <h3>Comments:</h3>
                <pre>
// This is a single-line comment

/* This is a
   multi-line comment */
</pre>

                <h3>cout and endl:</h3>
                <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    cout &lt;&lt; "Hello!" &lt;&lt; endl;
    cout &lt;&lt; "Welcome to C++." &lt;&lt; endl;
    cout &lt;&lt; "Line 1" &lt;&lt; "\n";   // \n also works
    cout &lt;&lt; "Line 2\n";
    return 0;
}
</pre>

                <h3>Output:</h3>
                <pre>
Hello!
Welcome to C++.
Line 1
Line 2
</pre>

                <h3>Escape Sequences:</h3>
                <pre>
\n   → New line
\t   → Tab space
\\   → Backslash
\"   → Double quote
\'   → Single quote
</pre>

                <h3>Printing Multiple Values:</h3>
                <pre>
cout &lt;&lt; "My name is " &lt;&lt; "Alice" &lt;&lt; " and I am " &lt;&lt; 20 &lt;&lt; " years old." &lt;&lt; endl;
// Output: My name is Alice and I am 20 years old.
</pre>

                <form method="GET" action="{{ route('cpp.quiz') }}">
                    <button>Quiz Lesson 1</button>
                </form>

                {{-- Lesson 2 --}}
                @if ($current_lesson < 2)
                    <hr><h2>Lesson 2 🔒</h2>
                    <p style="color:gray;">Complete Lesson 1 Quiz to unlock this lesson.</p>
                @endif

                @if ($current_lesson >= 2)
                    <hr>
                    <h2 id="lesson2">Lesson 2: Data Types, Variables, cin and cout</h2>

                    <p>C++ is a <b>statically typed</b> language — every variable must be declared with a type before use. C++ shares most primitive types with C and also adds <code>string</code>, <code>bool</code>, and more from its standard library.</p>

                    <h3>Common Data Types:</h3>
                    <pre>
int     → whole numbers          (e.g. 5, -3, 100)
float   → single precision decimal (e.g. 3.14f)
double  → double precision decimal  (e.g. 3.14159265)
char    → single character       (e.g. 'A', 'z')
bool    → true or false
string  → sequence of characters (e.g. "Hello")  ← requires &lt;string&gt; or &lt;iostream&gt;
</pre>

                    <h3>Declaring and Initializing Variables:</h3>
                    <pre>
int age = 20;
double price = 99.99;
bool isActive = true;
char grade = 'A';
string name = "Alice";

// auto — compiler deduces the type
auto score = 95;       // deduced as int
auto gpa   = 3.75;     // deduced as double
</pre>

                    <h3>Constants:</h3>
                    <pre>
const int MAX_SCORE = 100;    // value cannot change
const double PI = 3.14159;

// constexpr — evaluated at compile time
constexpr int DAYS = 7;
</pre>

                    <h3>Printing Variables with cout:</h3>
                    <pre>
#include &lt;iostream&gt;
#include &lt;string&gt;
using namespace std;

int main() {
    int age = 20;
    double gpa = 3.75;
    char grade = 'A';
    string name = "Alice";

    cout &lt;&lt; "Name: "  &lt;&lt; name  &lt;&lt; endl;
    cout &lt;&lt; "Age: "   &lt;&lt; age   &lt;&lt; endl;
    cout &lt;&lt; "GPA: "   &lt;&lt; gpa   &lt;&lt; endl;
    cout &lt;&lt; "Grade: " &lt;&lt; grade &lt;&lt; endl;
    return 0;
}
</pre>

                    <h3>Reading Input with cin:</h3>
                    <pre>
#include &lt;iostream&gt;
#include &lt;string&gt;
using namespace std;

int main() {
    string name;
    int age;
    double gpa;

    cout &lt;&lt; "Enter your name: ";
    cin &gt;&gt; name;                   // reads one word

    cout &lt;&lt; "Enter your age: ";
    cin &gt;&gt; age;

    cout &lt;&lt; "Enter your GPA: ";
    cin &gt;&gt; gpa;

    cout &lt;&lt; "\nName: " &lt;&lt; name &lt;&lt; endl;
    cout &lt;&lt; "Age: "   &lt;&lt; age  &lt;&lt; endl;
    cout &lt;&lt; "GPA: "   &lt;&lt; gpa  &lt;&lt; endl;
    return 0;
}
</pre>

                    <h3>Reading a Full Line (with spaces):</h3>
                    <pre>
string fullName;
cout &lt;&lt; "Enter full name: ";
cin.ignore();               // clear leftover newline from buffer
getline(cin, fullName);     // reads the entire line including spaces
cout &lt;&lt; "Hello, " &lt;&lt; fullName &lt;&lt; endl;
</pre>

                    <h3>Type Casting:</h3>
                    <pre>
// Implicit (automatic widening)
int x = 10;
double d = x;        // d = 10.0

// Explicit cast
double pi = 3.99;
int n = (int) pi;    // n = 3  (decimal truncated)
// or C++ style:
int m = static_cast&lt;int&gt;(pi);   // preferred in C++

// String conversions
int num = stoi("42");          // string → int
double val = stod("3.14");     // string → double
string s = to_string(100);     // int/double → string
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Use <code>getline(cin, str)</code> to read strings with spaces.</li>
                        <li>Call <code>cin.ignore()</code> before <code>getline</code> if a previous <code>cin &gt;&gt;</code> left a newline in the buffer.</li>
                        <li>Prefer <code>static_cast&lt;type&gt;()</code> over C-style casts in C++ — it is safer and more explicit.</li>
                        <li><code>string</code> in C++ is a class — it has methods like <code>.length()</code>, <code>.substr()</code>, <code>.find()</code>.</li>
                    </ul>

                    <form method="GET" action="{{ route('cpp.lesson2.quiz') }}">
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

                    <p>Control flow statements let your program make decisions. C++ uses <code>if</code>, <code>else if</code>, <code>else</code>, and <code>switch</code> — identical in syntax to C, with the addition of working with C++ types like <code>string</code> and <code>bool</code>.</p>

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
#include &lt;iostream&gt;
using namespace std;

int main() {
    int score;
    cout &lt;&lt; "Enter your score: ";
    cin &gt;&gt; score;

    if (score >= 75) {
        cout &lt;&lt; "You PASSED!" &lt;&lt; endl;
    } else {
        cout &lt;&lt; "You FAILED!" &lt;&lt; endl;
    }
    return 0;
}
</pre>

                    <h3>else if — Multiple Conditions:</h3>
                    <pre>
if (score >= 90) {
    cout &lt;&lt; "Grade: A" &lt;&lt; endl;
} else if (score >= 80) {
    cout &lt;&lt; "Grade: B" &lt;&lt; endl;
} else if (score >= 70) {
    cout &lt;&lt; "Grade: C" &lt;&lt; endl;
} else if (score >= 60) {
    cout &lt;&lt; "Grade: D" &lt;&lt; endl;
} else {
    cout &lt;&lt; "Grade: F" &lt;&lt; endl;
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
&&   → AND  (both must be true)
||   → OR   (at least one must be true)
!    → NOT  (reverses the condition)
</pre>

                    <h3>Example — Logical Operators:</h3>
                    <pre>
int age;
cin &gt;&gt; age;

if (age >= 18 && age <= 65) {
    cout &lt;&lt; "You are of working age." &lt;&lt; endl;
} else {
    cout &lt;&lt; "Outside working age range." &lt;&lt; endl;
}
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

                    <h3>Example — Day of the Week:</h3>
                    <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    int day;
    cout &lt;&lt; "Enter day (1-7): ";
    cin &gt;&gt; day;

    switch (day) {
        case 1: cout &lt;&lt; "Monday"    &lt;&lt; endl; break;
        case 2: cout &lt;&lt; "Tuesday"   &lt;&lt; endl; break;
        case 3: cout &lt;&lt; "Wednesday" &lt;&lt; endl; break;
        case 4: cout &lt;&lt; "Thursday"  &lt;&lt; endl; break;
        case 5: cout &lt;&lt; "Friday"    &lt;&lt; endl; break;
        case 6: cout &lt;&lt; "Saturday"  &lt;&lt; endl; break;
        case 7: cout &lt;&lt; "Sunday"    &lt;&lt; endl; break;
        default: cout &lt;&lt; "Invalid!" &lt;&lt; endl;
    }
    return 0;
}
</pre>

                    <h3>Ternary Operator:</h3>
                    <pre>
// condition ? valueIfTrue : valueIfFalse
int age = 20;
string result = (age >= 18) ? "Adult" : "Minor";
cout &lt;&lt; result &lt;&lt; endl;   // Adult
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Use <code>==</code> to compare primitives. For strings, use <code>==</code> directly on C++ <code>string</code> objects (unlike C's <code>strcmp</code>).</li>
                        <li>Always add <code>break;</code> in switch cases to prevent fall-through.</li>
                        <li>Switch in C++ works with <code>int</code>, <code>char</code>, and <code>enum</code> — NOT with <code>float</code>, <code>double</code>, or <code>string</code>.</li>
                        <li>Conditions must be inside parentheses <code>()</code>.</li>
                    </ul>

                    <form method="GET" action="{{ route('cpp.lesson3.quiz') }}">
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
                    <h2 id="lesson4">Lesson 4: Loops in C++</h2>

                    <p>Loops repeat a block of code multiple times. C++ has the same loop types as C — <b>for</b>, <b>while</b>, <b>do-while</b> — plus the modern <b>range-based for loop</b> introduced in C++11.</p>

                    <h2>Lesson 4.1: For Loop</h2>
                    <pre>
for (initialization; condition; update) {
    // code to repeat
}
</pre>

                    <h3>Example:</h3>
                    <pre>
#include &lt;iostream&gt;
using namespace std;

int main() {
    for (int i = 1; i &lt;= 5; i++) {
        cout &lt;&lt; i &lt;&lt; endl;
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
int i = 1;
while (i &lt;= 5) {
    cout &lt;&lt; i &lt;&lt; endl;
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
    cout &lt;&lt; i &lt;&lt; endl;
    i++;
} while (i &lt;= 5);
</pre>

                    <h2>Lesson 4.4: Range-Based For Loop (C++11)</h2>
                    <pre>
// Iterates over every element in an array or collection
int nums[] = {10, 20, 30, 40, 50};

for (int n : nums) {
    cout &lt;&lt; n &lt;&lt; endl;
}

// With auto
for (auto n : nums) {
    cout &lt;&lt; n &lt;&lt; endl;
}
</pre>

                    <h3>Difference Between Loops:</h3>
                    <pre>
for loop          → when number of iterations is known
while loop        → when iterations depend on a condition
do-while          → always runs at least once
range-based for   → when iterating over arrays or STL containers
</pre>

                    <h2>Lesson 4.5: break and continue</h2>
                    <pre>
break;    → exits the loop immediately
continue; → skips the rest of the current iteration
</pre>

                    <h3>Break Example:</h3>
                    <pre>
for (int i = 1; i &lt;= 10; i++) {
    if (i == 5) break;
    cout &lt;&lt; i &lt;&lt; endl;
}
// Prints 1 2 3 4 then stops
</pre>

                    <h3>Continue Example:</h3>
                    <pre>
for (int i = 1; i &lt;= 5; i++) {
    if (i == 3) continue;
    cout &lt;&lt; i &lt;&lt; endl;
}
// Prints 1 2 4 5 (skips 3)
</pre>

                    <h2>Lesson 4.6: Nested Loops and Star Patterns</h2>

                    <h3>Pattern 1 — Right Triangle:</h3>
                    <pre>
int n = 5;
for (int i = 1; i &lt;= n; i++) {
    for (int j = 1; j &lt;= i; j++) {
        cout &lt;&lt; "* ";
    }
    cout &lt;&lt; endl;
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

                    <h3>Pattern 2 — Pyramid:</h3>
                    <pre>
int n = 5;
for (int i = 1; i &lt;= n; i++) {
    for (int j = i; j &lt; n; j++) cout &lt;&lt; " ";
    for (int k = 1; k &lt;= (2 * i - 1); k++) cout &lt;&lt; "*";
    cout &lt;&lt; endl;
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

                    <h3>Pattern 3 — Square:</h3>
                    <pre>
int n = 4;
for (int i = 1; i &lt;= n; i++) {
    for (int j = 1; j &lt;= n; j++) {
        cout &lt;&lt; "* ";
    }
    cout &lt;&lt; endl;
}
</pre>
                    <h3>Output:</h3>
                    <pre>
* * * *
* * * *
* * * *
* * * *
</pre>

                    <form method="GET" action="{{ route('cpp.lesson4.quiz') }}">
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
                    <h2 id="lesson5">Lesson 5: Object-Oriented Programming in C++</h2>

                    <p>C++ was designed to bring OOP to C. The four pillars — <b>Encapsulation</b>, <b>Inheritance</b>, <b>Polymorphism</b>, and <b>Abstraction</b> — are all supported. C++ classes are more powerful than Java's in some ways (multiple inheritance, operator overloading, destructors).</p>

                    <h3>Classes and Objects:</h3>
                    <pre>
#include &lt;iostream&gt;
#include &lt;string&gt;
using namespace std;

class Dog {
public:
    string name;
    int age;

    // Constructor
    Dog(string n, int a) {
        name = n;
        age  = a;
    }

    // Method
    void bark() {
        cout &lt;&lt; name &lt;&lt; " says: Woof!" &lt;&lt; endl;
    }
};

int main() {
    Dog d1("Buddy", 3);
    Dog d2("Max", 5);

    d1.bark();   // Buddy says: Woof!
    d2.bark();   // Max says: Woof!

    cout &lt;&lt; d1.name &lt;&lt; " is " &lt;&lt; d1.age &lt;&lt; " years old." &lt;&lt; endl;
    return 0;
}
</pre>

                    <h3>Access Specifiers:</h3>
                    <pre>
public    → accessible from anywhere
private   → accessible only within the class (default for class members)
protected → accessible within the class and derived classes
</pre>

                    <h3>Encapsulation — Getters and Setters:</h3>
                    <pre>
class Person {
private:
    string name;
    int age;

public:
    // Getter
    string getName() { return name; }
    int getAge()     { return age; }

    // Setter
    void setName(string n) { name = n; }
    void setAge(int a) {
        if (a >= 0) age = a;   // validation
    }
};
</pre>

                    <h3>Destructor:</h3>
                    <pre>
class MyClass {
public:
    MyClass()  { cout &lt;&lt; "Object created!"   &lt;&lt; endl; }
    ~MyClass() { cout &lt;&lt; "Object destroyed!" &lt;&lt; endl; }
};

// Destructor is called automatically when object goes out of scope
</pre>

                    <h3>Inheritance — Derived Classes:</h3>
                    <pre>
class Animal {
public:
    void eat() {
        cout &lt;&lt; "This animal eats food." &lt;&lt; endl;
    }
};

class Cat : public Animal {    // Cat inherits from Animal
public:
    void meow() {
        cout &lt;&lt; "Meow!" &lt;&lt; endl;
    }
};

Cat c;
c.eat();    // This animal eats food.
c.meow();   // Meow!
</pre>

                    <h3>Polymorphism — Virtual Functions:</h3>
                    <pre>
class Animal {
public:
    virtual void speak() {     // virtual allows overriding
        cout &lt;&lt; "..." &lt;&lt; endl;
    }
};

class Dog : public Animal {
public:
    void speak() override {    // override keyword (C++11)
        cout &lt;&lt; "Woof!" &lt;&lt; endl;
    }
};

class Cat : public Animal {
public:
    void speak() override {
        cout &lt;&lt; "Meow!" &lt;&lt; endl;
    }
};

Animal* a = new Dog();
a->speak();   // Woof!  (runtime polymorphism via pointer)

Animal* b = new Cat();
b->speak();   // Meow!

delete a;
delete b;
</pre>

                    <h3>Multiple Inheritance (unique to C++):</h3>
                    <pre>
class Flyable {
public:
    void fly() { cout &lt;&lt; "Flying!" &lt;&lt; endl; }
};

class Swimmable {
public:
    void swim() { cout &lt;&lt; "Swimming!" &lt;&lt; endl; }
};

class Duck : public Flyable, public Swimmable {
    // inherits both fly() and swim()
};

Duck d;
d.fly();    // Flying!
d.swim();   // Swimming!
</pre>

                    <h3>Abstract Classes (Pure Virtual Functions):</h3>
                    <pre>
class Shape {
public:
    virtual double area() = 0;   // pure virtual — must be overridden
};

class Circle : public Shape {
    double radius;
public:
    Circle(double r) : radius(r) {}
    double area() override {
        return 3.14159 * radius * radius;
    }
};
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Use <code>virtual</code> for functions you intend to override in derived classes.</li>
                        <li>Use the <code>override</code> keyword (C++11) — it makes the compiler verify the override is correct.</li>
                        <li>A class can inherit from multiple base classes (multiple inheritance).</li>
                        <li>Always <code>delete</code> dynamically allocated objects to prevent memory leaks.</li>
                        <li>A class with at least one pure virtual function (<code>= 0</code>) is abstract and cannot be instantiated.</li>
                    </ul>

                    <form method="GET" action="{{ route('cpp.lesson5.quiz') }}">
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
                    <form method="GET" action="{{ route('cpp.final.exam') }}">
                        <button>Take Final Exam</button>
                    </form>
                @endif

            @endif {{-- end !$showQuiz --}}


            {{-- ============================================================ --}}
            {{-- QUIZ SECTIONS                                                --}}
            {{-- ============================================================ --}}

            @if ($showQuiz === true)
                {{-- ── Lesson 1 Quiz ── --}}
                <h2>Lesson 1 Quiz — Introduction to C++</h2>
                <form method="POST" action="{{ route('cpp.submit') }}">
                    @csrf

                    <p>1. Who created C++?</p>
                    <input type="radio" name="q1" value="a"> A. Dennis Ritchie<br>
                    <input type="radio" name="q1" value="b"> B. James Gosling<br>
                    <input type="radio" name="q1" value="c"> C. Bjarne Stroustrup<br>
                    <input type="radio" name="q1" value="d"> D. Guido van Rossum<br><br>

                    <p>2. What does #include &lt;iostream&gt; do?</p>
                    <input type="radio" name="q2" value="a"> A. Imports a math library<br>
                    <input type="radio" name="q2" value="b"> B. Includes the input/output stream library<br>
                    <input type="radio" name="q2" value="c"> C. Declares the main function<br>
                    <input type="radio" name="q2" value="d"> D. Ends the program<br><br>

                    <p>3. Which keyword outputs text to the screen in C++?</p>
                    <input type="radio" name="q3" value="a"> A. print<br>
                    <input type="radio" name="q3" value="b"> B. printf<br>
                    <input type="radio" name="q3" value="c"> C. cout<br>
                    <input type="radio" name="q3" value="d"> D. output<br><br>

                    <p>4. What operator is used with cout to send data?</p>
                    <input type="radio" name="q4" value="a"> A. >><br>
                    <input type="radio" name="q4" value="b"> B. &lt;&lt;<br>
                    <input type="radio" name="q4" value="c"> C. -><br>
                    <input type="radio" name="q4" value="d"> D. ::<br><br>

                    <p>5. What does "using namespace std;" do?</p>
                    <input type="radio" name="q5" value="a"> A. Creates a new namespace<br>
                    <input type="radio" name="q5" value="b"> B. Deletes the standard library<br>
                    <input type="radio" name="q5" value="c"> C. Allows using standard library names without std::<br>
                    <input type="radio" name="q5" value="d"> D. Imports all variables<br><br>

                    <p>6. What does endl do in C++?</p>
                    <input type="radio" name="q6" value="a"> A. Ends the program<br>
                    <input type="radio" name="q6" value="b"> B. Adds a new line<br>
                    <input type="radio" name="q6" value="c"> C. Moves to the next line and flushes the buffer<br>
                    <input type="radio" name="q6" value="d"> D. Declares the end of a variable<br><br>

                    <p>7. What is the correct file extension for a C++ source file?</p>
                    <input type="radio" name="q7" value="a"> A. .c<br>
                    <input type="radio" name="q7" value="b"> B. .java<br>
                    <input type="radio" name="q7" value="c"> C. .cpp<br>
                    <input type="radio" name="q7" value="d"> D. .py<br><br>

                    <p>8. How do you write a single-line comment in C++?</p>
                    <input type="radio" name="q8" value="a"> A. # comment<br>
                    <input type="radio" name="q8" value="b"> B. // comment<br>
                    <input type="radio" name="q8" value="c"> C. &lt;!-- comment --&gt;<br>
                    <input type="radio" name="q8" value="d"> D. /* comment<br><br>

                    <p>9. What does return 0; in main() indicate?</p>
                    <input type="radio" name="q9" value="a"> A. The program failed<br>
                    <input type="radio" name="q9" value="b"> B. The program loops back<br>
                    <input type="radio" name="q9" value="c"> C. The program ended successfully<br>
                    <input type="radio" name="q9" value="d"> D. The program pauses<br><br>

                    <p>10. C++ was created as an extension of which language?</p>
                    <input type="radio" name="q10" value="a"> A. Java<br>
                    <input type="radio" name="q10" value="b"> B. Python<br>
                    <input type="radio" name="q10" value="c"> C. C<br>
                    <input type="radio" name="q10" value="d"> D. Pascal<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson2')
                {{-- ── Lesson 2 Quiz ── --}}
                <h2>Lesson 2 Quiz — Data Types, Variables, cin and cout</h2>
                <form method="POST" action="{{ route('cpp.lesson2.submit') }}">
                    @csrf

                    <p>1. Which data type stores true or false in C++?</p>
                    <input type="radio" name="q1" value="a"> A. int<br>
                    <input type="radio" name="q1" value="b"> B. char<br>
                    <input type="radio" name="q1" value="c"> C. bool<br>
                    <input type="radio" name="q1" value="d"> D. float<br><br>

                    <p>2. Which keyword reads input from the user in C++?</p>
                    <input type="radio" name="q2" value="a"> A. cout<br>
                    <input type="radio" name="q2" value="b"> B. scanf<br>
                    <input type="radio" name="q2" value="c"> C. cin<br>
                    <input type="radio" name="q2" value="d"> D. input<br><br>

                    <p>3. What operator is used with cin to read data?</p>
                    <input type="radio" name="q3" value="a"> A. &lt;&lt;<br>
                    <input type="radio" name="q3" value="b"> B. -><br>
                    <input type="radio" name="q3" value="c"> C. ::<br>
                    <input type="radio" name="q3" value="d"> D. >><br><br>

                    <p>4. Which keyword makes a variable a constant in C++?</p>
                    <input type="radio" name="q4" value="a"> A. static<br>
                    <input type="radio" name="q4" value="b"> B. final<br>
                    <input type="radio" name="q4" value="c"> C. const<br>
                    <input type="radio" name="q4" value="d"> D. immutable<br><br>

                    <p>5. Which function reads a full line of input including spaces?</p>
                    <input type="radio" name="q5" value="a"> A. cin >><br>
                    <input type="radio" name="q5" value="b"> B. scanf<br>
                    <input type="radio" name="q5" value="c"> C. getline(cin, str)<br>
                    <input type="radio" name="q5" value="d"> D. readline()<br><br>

                    <p>6. Which is NOT a valid C++ data type?</p>
                    <input type="radio" name="q6" value="a"> A. int<br>
                    <input type="radio" name="q6" value="b"> B. bool<br>
                    <input type="radio" name="q6" value="c"> C. real<br>
                    <input type="radio" name="q6" value="d"> D. double<br><br>

                    <p>7. What does static_cast&lt;int&gt;(3.9) return?</p>
                    <input type="radio" name="q7" value="a"> A. 4<br>
                    <input type="radio" name="q7" value="b"> B. 3<br>
                    <input type="radio" name="q7" value="c"> C. 3.9<br>
                    <input type="radio" name="q7" value="d"> D. Error<br><br>

                    <p>8. Which keyword lets the compiler deduce a variable's type?</p>
                    <input type="radio" name="q8" value="a"> A. var<br>
                    <input type="radio" name="q8" value="b"> B. let<br>
                    <input type="radio" name="q8" value="c"> C. auto<br>
                    <input type="radio" name="q8" value="d"> D. type<br><br>

                    <p>9. Which function converts a string "42" to an integer in C++?</p>
                    <input type="radio" name="q9" value="a"> A. parseInt("42")<br>
                    <input type="radio" name="q9" value="b"> B. Integer.parseInt("42")<br>
                    <input type="radio" name="q9" value="c"> C. stoi("42")<br>
                    <input type="radio" name="q9" value="d"> D. atoi("42")<br><br>

                    <p>10. Which function converts an int to a string in C++?</p>
                    <input type="radio" name="q10" value="a"> A. toString(100)<br>
                    <input type="radio" name="q10" value="b"> B. to_string(100)<br>
                    <input type="radio" name="q10" value="c"> C. String(100)<br>
                    <input type="radio" name="q10" value="d"> D. itoa(100)<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson3')
                {{-- ── Lesson 3 Quiz ── --}}
                <h2>Lesson 3 Quiz — Control Flow</h2>
                <form method="POST" action="{{ route('cpp.lesson3.submit') }}">
                    @csrf

                    <p>1. Which operator checks equality in C++?</p>
                    <input type="radio" name="q1" value="a"> A. =<br>
                    <input type="radio" name="q1" value="b"> B. ===<br>
                    <input type="radio" name="q1" value="c"> C. ==<br>
                    <input type="radio" name="q1" value="d"> D. !=<br><br>

                    <p>2. What does the && operator mean in C++?</p>
                    <input type="radio" name="q2" value="a"> A. OR<br>
                    <input type="radio" name="q2" value="b"> B. NOT<br>
                    <input type="radio" name="q2" value="c"> C. AND<br>
                    <input type="radio" name="q2" value="d"> D. XOR<br><br>

                    <p>3. What does the || operator mean?</p>
                    <input type="radio" name="q3" value="a"> A. AND<br>
                    <input type="radio" name="q3" value="b"> B. OR<br>
                    <input type="radio" name="q3" value="c"> C. NOT<br>
                    <input type="radio" name="q3" value="d"> D. EQUAL<br><br>

                    <p>4. Which type CANNOT be used in a C++ switch?</p>
                    <input type="radio" name="q4" value="a"> A. int<br>
                    <input type="radio" name="q4" value="b"> B. char<br>
                    <input type="radio" name="q4" value="c"> C. double<br>
                    <input type="radio" name="q4" value="d"> D. enum<br><br>

                    <p>5. What keyword prevents fall-through in a switch?</p>
                    <input type="radio" name="q5" value="a"> A. stop<br>
                    <input type="radio" name="q5" value="b"> B. end<br>
                    <input type="radio" name="q5" value="c"> C. break<br>
                    <input type="radio" name="q5" value="d"> D. exit<br><br>

                    <p>6. What does the ternary expression (10 > 5) ? "Yes" : "No" return?</p>
                    <input type="radio" name="q6" value="a"> A. No<br>
                    <input type="radio" name="q6" value="b"> B. null<br>
                    <input type="radio" name="q6" value="c"> C. Yes<br>
                    <input type="radio" name="q6" value="d"> D. Error<br><br>

                    <p>7. What does != mean?</p>
                    <input type="radio" name="q7" value="a"> A. Equal to<br>
                    <input type="radio" name="q7" value="b"> B. Greater than<br>
                    <input type="radio" name="q7" value="c"> C. Not equal to<br>
                    <input type="radio" name="q7" value="d"> D. Less than<br><br>

                    <p>8. The default case in switch runs when?</p>
                    <input type="radio" name="q8" value="a"> A. The first case matches<br>
                    <input type="radio" name="q8" value="b"> B. No case matches<br>
                    <input type="radio" name="q8" value="c"> C. Every time<br>
                    <input type="radio" name="q8" value="d"> D. After break<br><br>

                    <p>9. The ! operator in C++ is used for?</p>
                    <input type="radio" name="q9" value="a"> A. Multiplication<br>
                    <input type="radio" name="q9" value="b"> B. Division<br>
                    <input type="radio" name="q9" value="c"> C. Logical NOT<br>
                    <input type="radio" name="q9" value="d"> D. Modulus<br><br>

                    <p>10. Unlike C, C++ string objects can be compared using?</p>
                    <input type="radio" name="q10" value="a"> A. strcmp()<br>
                    <input type="radio" name="q10" value="b"> B. strcmpi()<br>
                    <input type="radio" name="q10" value="c"> C. ==<br>
                    <input type="radio" name="q10" value="d"> D. .equals()<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson4')
                {{-- ── Lesson 4 Quiz ── --}}
                <h2>Lesson 4 Quiz — Loops</h2>
                <form method="POST" action="{{ route('cpp.lesson4.submit') }}">
                    @csrf

                    <p>1. Which loop is best when the number of iterations is known?</p>
                    <input type="radio" name="q1" value="a"> A. while<br>
                    <input type="radio" name="q1" value="b"> B. do-while<br>
                    <input type="radio" name="q1" value="c"> C. for<br>
                    <input type="radio" name="q1" value="d"> D. switch<br><br>

                    <p>2. What is the correct syntax of a for loop in C++?</p>
                    <input type="radio" name="q2" value="a"> A. for (init, condition, update)<br>
                    <input type="radio" name="q2" value="b"> B. for [init; condition; update]<br>
                    <input type="radio" name="q2" value="c"> C. for (init; condition; update)<br>
                    <input type="radio" name="q2" value="d"> D. loop (init; condition; update)<br><br>

                    <p>3. Which keyword immediately exits a loop in C++?</p>
                    <input type="radio" name="q3" value="a"> A. exit<br>
                    <input type="radio" name="q3" value="b"> B. stop<br>
                    <input type="radio" name="q3" value="c"> C. return<br>
                    <input type="radio" name="q3" value="d"> D. break<br><br>

                    <p>4. Which keyword skips the current iteration?</p>
                    <input type="radio" name="q4" value="a"> A. skip<br>
                    <input type="radio" name="q4" value="b"> B. next<br>
                    <input type="radio" name="q4" value="c"> C. continue<br>
                    <input type="radio" name="q4" value="d"> D. pass<br><br>

                    <p>5. Which loop always executes its body at least once?</p>
                    <input type="radio" name="q5" value="a"> A. for<br>
                    <input type="radio" name="q5" value="b"> B. while<br>
                    <input type="radio" name="q5" value="c"> C. do-while<br>
                    <input type="radio" name="q5" value="d"> D. range-based for<br><br>

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

                    <p>8. What is the correct range-based for syntax for array "nums"?</p>
                    <input type="radio" name="q8" value="a"> A. for (nums : int n)<br>
                    <input type="radio" name="q8" value="b"> B. foreach (int n in nums)<br>
                    <input type="radio" name="q8" value="c"> C. for (int n : nums)<br>
                    <input type="radio" name="q8" value="d"> D. for each (int n, nums)<br><br>

                    <p>9. What does i++ do?</p>
                    <input type="radio" name="q9" value="a"> A. Decrease i by 1<br>
                    <input type="radio" name="q9" value="b"> B. Reset i to 0<br>
                    <input type="radio" name="q9" value="c"> C. Multiply i by 2<br>
                    <input type="radio" name="q9" value="d"> D. Increase i by 1<br><br>

                    <p>10. The range-based for loop was introduced in which C++ version?</p>
                    <input type="radio" name="q10" value="a"> A. C++98<br>
                    <input type="radio" name="q10" value="b"> B. C++03<br>
                    <input type="radio" name="q10" value="c"> C. C++11<br>
                    <input type="radio" name="q10" value="d"> D. C++17<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson5')
                {{-- ── Lesson 5 Quiz ── --}}
                <h2>Lesson 5 Quiz — Object-Oriented Programming</h2>
                <form method="POST" action="{{ route('cpp.lesson5.submit') }}">
                    @csrf

                    <p>1. What keyword defines a class in C++?</p>
                    <input type="radio" name="q1" value="a"> A. object<br>
                    <input type="radio" name="q1" value="b"> B. struct<br>
                    <input type="radio" name="q1" value="c"> C. class<br>
                    <input type="radio" name="q1" value="d"> D. type<br><br>

                    <p>2. What is the default access specifier for class members in C++?</p>
                    <input type="radio" name="q2" value="a"> A. public<br>
                    <input type="radio" name="q2" value="b"> B. protected<br>
                    <input type="radio" name="q2" value="c"> C. private<br>
                    <input type="radio" name="q2" value="d"> D. internal<br><br>

                    <p>3. What is a destructor in C++?</p>
                    <input type="radio" name="q3" value="a"> A. A method that creates objects<br>
                    <input type="radio" name="q3" value="b"> B. A method called automatically when an object is destroyed<br>
                    <input type="radio" name="q3" value="c"> C. A loop control statement<br>
                    <input type="radio" name="q3" value="d"> D. A type of pointer<br><br>

                    <p>4. Which keyword enables runtime polymorphism in C++?</p>
                    <input type="radio" name="q4" value="a"> A. static<br>
                    <input type="radio" name="q4" value="b"> B. const<br>
                    <input type="radio" name="q4" value="c"> C. virtual<br>
                    <input type="radio" name="q4" value="d"> D. inline<br><br>

                    <p>5. Which keyword is used to inherit from a class in C++?</p>
                    <input type="radio" name="q5" value="a"> A. implements<br>
                    <input type="radio" name="q5" value="b"> B. extends<br>
                    <input type="radio" name="q5" value="c"> C. inherits<br>
                    <input type="radio" name="q5" value="d"> D. : public<br><br>

                    <p>6. What does the override keyword do in C++11?</p>
                    <input type="radio" name="q6" value="a"> A. Prevents a method from being called<br>
                    <input type="radio" name="q6" value="b"> B. Verifies the method overrides a virtual function<br>
                    <input type="radio" name="q6" value="c"> C. Makes a method static<br>
                    <input type="radio" name="q6" value="d"> D. Hides the method from subclasses<br><br>

                    <p>7. What makes a C++ class abstract?</p>
                    <input type="radio" name="q7" value="a"> A. Having no constructor<br>
                    <input type="radio" name="q7" value="b"> B. Having at least one pure virtual function (= 0)<br>
                    <input type="radio" name="q7" value="c"> C. Using the abstract keyword<br>
                    <input type="radio" name="q7" value="d"> D. Having only private members<br><br>

                    <p>8. Unlike Java, C++ supports?</p>
                    <input type="radio" name="q8" value="a"> A. Single inheritance only<br>
                    <input type="radio" name="q8" value="b"> B. No inheritance<br>
                    <input type="radio" name="q8" value="c"> C. Multiple inheritance<br>
                    <input type="radio" name="q8" value="d"> D. Interface inheritance only<br><br>

                    <p>9. What does the "this" pointer refer to in C++?</p>
                    <input type="radio" name="q9" value="a"> A. The parent class<br>
                    <input type="radio" name="q9" value="b"> B. The current object instance<br>
                    <input type="radio" name="q9" value="c"> C. A static member<br>
                    <input type="radio" name="q9" value="d"> D. The main function<br><br>

                    <p>10. Encapsulation in C++ is achieved by?</p>
                    <input type="radio" name="q10" value="a"> A. Making all members public<br>
                    <input type="radio" name="q10" value="b"> B. Making members private and providing public getters/setters<br>
                    <input type="radio" name="q10" value="c"> C. Using static methods only<br>
                    <input type="radio" name="q10" value="d"> D. Inheriting from multiple classes<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'final')
                {{-- ── Final Exam (50 questions) ── --}}
                <h2>🎓 C++ Programming Final Exam</h2>
                <p>This exam covers all lessons. Answer all 50 questions.</p>

                <form method="POST" action="{{ route('cpp.final.submit') }}">
                    @csrf

                    <h3>— Introduction to C++ (Q1–10) —</h3>

                    <p>1. Who created C++?</p>
                    <input type="radio" name="q1" value="a"> A. Dennis Ritchie<br>
                    <input type="radio" name="q1" value="b"> B. James Gosling<br>
                    <input type="radio" name="q1" value="c"> C. Bjarne Stroustrup<br>
                    <input type="radio" name="q1" value="d"> D. Guido van Rossum<br><br>

                    <p>2. C++ was created in what year?</p>
                    <input type="radio" name="q2" value="a"> A. 1972<br>
                    <input type="radio" name="q2" value="b"> B. 1983<br>
                    <input type="radio" name="q2" value="c"> C. 1995<br>
                    <input type="radio" name="q2" value="d"> D. 2000<br><br>

                    <p>3. What does #include &lt;iostream&gt; do?</p>
                    <input type="radio" name="q3" value="a"> A. Imports a math library<br>
                    <input type="radio" name="q3" value="b"> B. Includes the input/output stream library<br>
                    <input type="radio" name="q3" value="c"> C. Declares the main function<br>
                    <input type="radio" name="q3" value="d"> D. Ends the program<br><br>

                    <p>4. Which keyword outputs text to the screen in C++?</p>
                    <input type="radio" name="q4" value="a"> A. print<br>
                    <input type="radio" name="q4" value="b"> B. printf<br>
                    <input type="radio" name="q4" value="c"> C. cout<br>
                    <input type="radio" name="q4" value="d"> D. output<br><br>

                    <p>5. What operator sends data to cout?</p>
                    <input type="radio" name="q5" value="a"> A. >><br>
                    <input type="radio" name="q5" value="b"> B. &lt;&lt;<br>
                    <input type="radio" name="q5" value="c"> C. -><br>
                    <input type="radio" name="q5" value="d"> D. ::<br><br>

                    <p>6. What does "using namespace std;" allow?</p>
                    <input type="radio" name="q6" value="a"> A. Creates a new namespace<br>
                    <input type="radio" name="q6" value="b"> B. Allows using standard names without std::<br>
                    <input type="radio" name="q6" value="c"> C. Imports all variables<br>
                    <input type="radio" name="q6" value="d"> D. Deletes the standard library<br><br>

                    <p>7. What does endl do?</p>
                    <input type="radio" name="q7" value="a"> A. Ends the program<br>
                    <input type="radio" name="q7" value="b"> B. Adds a tab<br>
                    <input type="radio" name="q7" value="c"> C. Moves to next line and flushes the buffer<br>
                    <input type="radio" name="q7" value="d"> D. Declares end of a variable<br><br>

                    <p>8. What is the correct file extension for C++?</p>
                    <input type="radio" name="q8" value="a"> A. .c<br>
                    <input type="radio" name="q8" value="b"> B. .java<br>
                    <input type="radio" name="q8" value="c"> C. .cpp<br>
                    <input type="radio" name="q8" value="d"> D. .py<br><br>

                    <p>9. What does return 0; in main() indicate?</p>
                    <input type="radio" name="q9" value="a"> A. Program failed<br>
                    <input type="radio" name="q9" value="b"> B. Program loops back<br>
                    <input type="radio" name="q9" value="c"> C. Program ended successfully<br>
                    <input type="radio" name="q9" value="d"> D. Program pauses<br><br>

                    <p>10. C++ was created as an extension of?</p>
                    <input type="radio" name="q10" value="a"> A. Java<br>
                    <input type="radio" name="q10" value="b"> B. Python<br>
                    <input type="radio" name="q10" value="c"> C. C<br>
                    <input type="radio" name="q10" value="d"> D. Pascal<br><br>

                    <h3>— Data Types &amp; Variables (Q11–20) —</h3>

                    <p>11. Which data type stores true or false in C++?</p>
                    <input type="radio" name="q11" value="a"> A. int<br>
                    <input type="radio" name="q11" value="b"> B. char<br>
                    <input type="radio" name="q11" value="c"> C. bool<br>
                    <input type="radio" name="q11" value="d"> D. float<br><br>

                    <p>12. Which keyword reads input in C++?</p>
                    <input type="radio" name="q12" value="a"> A. cout<br>
                    <input type="radio" name="q12" value="b"> B. scanf<br>
                    <input type="radio" name="q12" value="c"> C. cin<br>
                    <input type="radio" name="q12" value="d"> D. input<br><br>

                    <p>13. Which keyword makes a variable constant in C++?</p>
                    <input type="radio" name="q13" value="a"> A. static<br>
                    <input type="radio" name="q13" value="b"> B. final<br>
                    <input type="radio" name="q13" value="c"> C. const<br>
                    <input type="radio" name="q13" value="d"> D. immutable<br><br>

                    <p>14. Which function reads a full line including spaces?</p>
                    <input type="radio" name="q14" value="a"> A. cin >><br>
                    <input type="radio" name="q14" value="b"> B. scanf<br>
                    <input type="radio" name="q14" value="c"> C. getline(cin, str)<br>
                    <input type="radio" name="q14" value="d"> D. readline()<br><br>

                    <p>15. What does static_cast&lt;int&gt;(3.9) return?</p>
                    <input type="radio" name="q15" value="a"> A. 4<br>
                    <input type="radio" name="q15" value="b"> B. 3<br>
                    <input type="radio" name="q15" value="c"> C. 3.9<br>
                    <input type="radio" name="q15" value="d"> D. Error<br><br>

                    <p>16. Which is NOT a valid C++ data type?</p>
                    <input type="radio" name="q16" value="a"> A. int<br>
                    <input type="radio" name="q16" value="b"> B. bool<br>
                    <input type="radio" name="q16" value="c"> C. real<br>
                    <input type="radio" name="q16" value="d"> D. double<br><br>

                    <p>17. Which keyword lets the compiler deduce a type?</p>
                    <input type="radio" name="q17" value="a"> A. var<br>
                    <input type="radio" name="q17" value="b"> B. let<br>
                    <input type="radio" name="q17" value="c"> C. auto<br>
                    <input type="radio" name="q17" value="d"> D. type<br><br>

                    <p>18. Which converts string "42" to int in C++?</p>
                    <input type="radio" name="q18" value="a"> A. parseInt("42")<br>
                    <input type="radio" name="q18" value="b"> B. Integer.parseInt("42")<br>
                    <input type="radio" name="q18" value="c"> C. stoi("42")<br>
                    <input type="radio" name="q18" value="d"> D. convert("42")<br><br>

                    <p>19. Which converts int to string in C++?</p>
                    <input type="radio" name="q19" value="a"> A. toString(100)<br>
                    <input type="radio" name="q19" value="b"> B. to_string(100)<br>
                    <input type="radio" name="q19" value="c"> C. String(100)<br>
                    <input type="radio" name="q19" value="d"> D. itoa(100)<br><br>

                    <p>20. What operator is used with cin to read data?</p>
                    <input type="radio" name="q20" value="a"> A. &lt;&lt;<br>
                    <input type="radio" name="q20" value="b"> B. -><br>
                    <input type="radio" name="q20" value="c"> C. >><br>
                    <input type="radio" name="q20" value="d"> D. ::<br><br>

                    <h3>— Control Flow (Q21–30) —</h3>

                    <p>21. Which operator checks equality in C++?</p>
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

                    <p>24. Which type CANNOT be used in a C++ switch?</p>
                    <input type="radio" name="q24" value="a"> A. int<br>
                    <input type="radio" name="q24" value="b"> B. char<br>
                    <input type="radio" name="q24" value="c"> C. double<br>
                    <input type="radio" name="q24" value="d"> D. enum<br><br>

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

                    <p>27. The ! operator means?</p>
                    <input type="radio" name="q27" value="a"> A. Multiply<br>
                    <input type="radio" name="q27" value="b"> B. Divide<br>
                    <input type="radio" name="q27" value="c"> C. Logical NOT<br>
                    <input type="radio" name="q27" value="d"> D. Modulus<br><br>

                    <p>28. What does (10 > 5) ? "Yes" : "No" return?</p>
                    <input type="radio" name="q28" value="a"> A. No<br>
                    <input type="radio" name="q28" value="b"> B. null<br>
                    <input type="radio" name="q28" value="c"> C. Yes<br>
                    <input type="radio" name="q28" value="d"> D. Error<br><br>

                    <p>29. If condition is false and no else exists?</p>
                    <input type="radio" name="q29" value="a"> A. Program crashes<br>
                    <input type="radio" name="q29" value="b"> B. If block runs<br>
                    <input type="radio" name="q29" value="c"> C. Nothing, program continues<br>
                    <input type="radio" name="q29" value="d"> D. Error thrown<br><br>

                    <p>30. C++ string objects (unlike C strings) can be compared with?</p>
                    <input type="radio" name="q30" value="a"> A. strcmp()<br>
                    <input type="radio" name="q30" value="b"> B. .equals()<br>
                    <input type="radio" name="q30" value="c"> C. ==<br>
                    <input type="radio" name="q30" value="d"> D. .compare() only<br><br>

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
                    <input type="radio" name="q32" value="d"> D. range-based for<br><br>

                    <p>33. Keyword to exit a loop?</p>
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

                    <p>39. The range-based for loop was introduced in?</p>
                    <input type="radio" name="q39" value="a"> A. C++98<br>
                    <input type="radio" name="q39" value="b"> B. C++03<br>
                    <input type="radio" name="q39" value="c"> C. C++11<br>
                    <input type="radio" name="q39" value="d"> D. C++17<br><br>

                    <p>40. What is the correct range-based for syntax for array "nums"?</p>
                    <input type="radio" name="q40" value="a"> A. for (nums : int n)<br>
                    <input type="radio" name="q40" value="b"> B. foreach (int n in nums)<br>
                    <input type="radio" name="q40" value="c"> C. for (int n : nums)<br>
                    <input type="radio" name="q40" value="d"> D. for each (int n, nums)<br><br>

                    <h3>— Object-Oriented Programming (Q41–50) —</h3>

                    <p>41. What keyword defines a class in C++?</p>
                    <input type="radio" name="q41" value="a"> A. object<br>
                    <input type="radio" name="q41" value="b"> B. struct<br>
                    <input type="radio" name="q41" value="c"> C. class<br>
                    <input type="radio" name="q41" value="d"> D. type<br><br>

                    <p>42. What is the default access specifier for class members?</p>
                    <input type="radio" name="q42" value="a"> A. public<br>
                    <input type="radio" name="q42" value="b"> B. protected<br>
                    <input type="radio" name="q42" value="c"> C. private<br>
                    <input type="radio" name="q42" value="d"> D. internal<br><br>

                    <p>43. What is a destructor?</p>
                    <input type="radio" name="q43" value="a"> A. A method that creates objects<br>
                    <input type="radio" name="q43" value="b"> B. A method called automatically when an object is destroyed<br>
                    <input type="radio" name="q43" value="c"> C. A loop control statement<br>
                    <input type="radio" name="q43" value="d"> D. A type of pointer<br><br>

                    <p>44. Which keyword enables runtime polymorphism?</p>
                    <input type="radio" name="q44" value="a"> A. static<br>
                    <input type="radio" name="q44" value="b"> B. const<br>
                    <input type="radio" name="q44" value="c"> C. virtual<br>
                    <input type="radio" name="q44" value="d"> D. inline<br><br>

                    <p>45. Inheritance syntax in C++ is?</p>
                    <input type="radio" name="q45" value="a"> A. class Dog implements Animal<br>
                    <input type="radio" name="q45" value="b"> B. class Dog extends Animal<br>
                    <input type="radio" name="q45" value="c"> C. class Dog : public Animal<br>
                    <input type="radio" name="q45" value="d"> D. class Dog inherits Animal<br><br>

                    <p>46. What does the override keyword do in C++11?</p>
                    <input type="radio" name="q46" value="a"> A. Prevents a method from being called<br>
                    <input type="radio" name="q46" value="b"> B. Verifies the method overrides a virtual function<br>
                    <input type="radio" name="q46" value="c"> C. Makes a method static<br>
                    <input type="radio" name="q46" value="d"> D. Hides the method<br><br>

                    <p>47. A C++ class is abstract when it has?</p>
                    <input type="radio" name="q47" value="a"> A. No constructor<br>
                    <input type="radio" name="q47" value="b"> B. At least one pure virtual function (= 0)<br>
                    <input type="radio" name="q47" value="c"> C. The abstract keyword<br>
                    <input type="radio" name="q47" value="d"> D. Only private members<br><br>

                    <p>48. Unlike Java, C++ supports?</p>
                    <input type="radio" name="q48" value="a"> A. Single inheritance only<br>
                    <input type="radio" name="q48" value="b"> B. No inheritance<br>
                    <input type="radio" name="q48" value="c"> C. Multiple inheritance<br>
                    <input type="radio" name="q48" value="d"> D. Interface inheritance only<br><br>

                    <p>49. Encapsulation in C++ is achieved by?</p>
                    <input type="radio" name="q49" value="a"> A. Making all members public<br>
                    <input type="radio" name="q49" value="b"> B. Making members private with public getters/setters<br>
                    <input type="radio" name="q49" value="c"> C. Using static methods only<br>
                    <input type="radio" name="q49" value="d"> D. Inheriting from multiple classes<br><br>

                    <p>50. What does the "this" pointer refer to in C++?</p>
                    <input type="radio" name="q50" value="a"> A. The parent class<br>
                    <input type="radio" name="q50" value="b"> B. A static member<br>
                    <input type="radio" name="q50" value="c"> C. The main function<br>
                    <input type="radio" name="q50" value="d"> D. The current object instance<br><br>

                    <button type="submit">Submit Final Exam</button>
                </form>

            @endif {{-- end quiz sections --}}

        </div>
    </div>

</body>
</html>
