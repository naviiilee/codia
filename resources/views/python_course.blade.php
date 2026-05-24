<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python Programming Course</title>
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
                            'py_lesson1' => route('py.course') . '#lesson2',
                            'py_lesson2' => route('py.course') . '#lesson3',
                            'py_lesson3' => route('py.course') . '#lesson4',
                            'py_lesson4' => route('py.course') . '#lesson5',
                            'py_lesson5' => route('py.course') . '#final',
                            'py_final'   => route('dashboard'),
                            default      => route('py.course'),
                        };
                        $nextLabel = session('quiz') === 'py_final' ? 'Back to Dashboard' : 'Proceed to Next Lesson →';
                    @endphp
                    <a href="{{ $nextRoute }}">
                        <button type="button">{{ $nextLabel }}</button>
                    </a>
                @else
                    @php
                        $retakeRoute = match(session('quiz')) {
                            'py_lesson1' => route('py.quiz'),
                            'py_lesson2' => route('py.lesson2.quiz'),
                            'py_lesson3' => route('py.lesson3.quiz'),
                            'py_lesson4' => route('py.lesson4.quiz'),
                            'py_lesson5' => route('py.lesson5.quiz'),
                            'py_final'   => route('py.final.exam'),
                            default      => route('py.quiz'),
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
                    <button type="button">View Python Certificate</button>
                </a>
            </div>
        @endif

        <div class="lesson-box">

            {{-- ============================================================ --}}
            {{-- LESSON CONTENT                                               --}}
            {{-- ============================================================ --}}
            @if (!$showQuiz)

                {{-- ── LESSON 1 ── --}}
                <h2>Lesson 1: Introduction to Python</h2>

                <p><b>Python</b> is a high-level, general-purpose programming language created by <b>Guido van Rossum</b> and first released in <b>1991</b>. It emphasizes <b>code readability</b> and simplicity, using indentation instead of curly braces to define code blocks. Python is widely used in web development, data science, artificial intelligence, automation, and scripting.</p>

                <h3>Why Learn Python?</h3>
                <ul>
                    <li>Easy to read and write — often reads like plain English</li>
                    <li>Versatile — used for web apps, AI, data analysis, automation, and more</li>
                    <li>Huge ecosystem of libraries (NumPy, Pandas, Django, Flask, TensorFlow)</li>
                    <li>Interpreted — no compilation step needed; run code directly</li>
                    <li>One of the most in-demand languages in the job market</li>
                </ul>

                <h3>Basic Structure of a Python Program:</h3>
                <pre>
# This is a Python program
print("Hello, World!")
</pre>

                <h3>Explanation:</h3>
                <pre>
# This is a Python program
→ A comment. Python ignores everything after # on that line.

print("Hello, World!")
→ print() is a built-in function that outputs text to the screen.
→ Strings are enclosed in single '' or double "" quotes.
→ No semicolons needed — Python uses newlines to end statements.
→ No main() function required — Python runs top to bottom.
</pre>

                <h3>Running a Python Program:</h3>
                <pre>
# Save the file as hello.py, then run:
python hello.py
# or on some systems:
python3 hello.py
</pre>

                <h3>Python Version Note:</h3>
                <pre>
Python 2  → legacy, no longer maintained (end of life: 2020)
Python 3  → current version, always use Python 3 for new projects
</pre>

                <h3>Important Notes:</h3>
                <ul>
                    <li>Python uses <b>indentation</b> (4 spaces or 1 tab) to define blocks — this is mandatory, not optional.</li>
                    <li>Python is <strong>case-sensitive</strong> — <code>Print</code> and <code>print</code> are different.</li>
                    <li>No semicolons at end of lines (unlike C, C++, Java).</li>
                    <li>Use <code>#</code> for single-line comments and <code>"""..."""</code> for multi-line comments (docstrings).</li>
                    <li>Python is <b>dynamically typed</b> — you do not declare variable types.</li>
                </ul>

                <h2>Lesson 1.1: Comments and Basic Output</h2>

                <h3>Comments:</h3>
                <pre>
# This is a single-line comment

"""
This is a
multi-line comment
(technically a string literal used as a docstring)
"""
</pre>

                <h3>print() and Escape Sequences:</h3>
                <pre>
print("Hello!")
print("Welcome to Python.")
print("Line 1\nLine 2")    # \n = new line
print("Name:\tAlice")      # \t = tab
print("She said \"Hi\"")   # \" = double quote inside string
</pre>

                <h3>Output:</h3>
                <pre>
Hello!
Welcome to Python.
Line 1
Line 2
Name:   Alice
She said "Hi"
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
# Using comma (adds space between items)
print("My name is", "Alice", "and I am", 20, "years old.")
# Output: My name is Alice and I am 20 years old.

# Using + (concatenation — must be same type)
print("My name is " + "Alice")

# Using f-strings (recommended)
name = "Alice"
age = 20
print(f"My name is {name} and I am {age} years old.")
</pre>

                <form method="GET" action="{{ route('py.quiz') }}">
                    <button>Quiz Lesson 1</button>
                </form>

                {{-- Lesson 2 --}}
                @if ($current_lesson < 2)
                    <hr><h2>Lesson 2 🔒</h2>
                    <p style="color:gray;">Complete Lesson 1 Quiz to unlock this lesson.</p>
                @endif

                @if ($current_lesson >= 2)
                    <hr>
                    <h2 id="lesson2">Lesson 2: Variables, Data Types, and Input</h2>

                    <p>Python is <b>dynamically typed</b> — you do not declare a type when creating a variable. Python automatically determines the type based on the value assigned. Variables are created the moment you assign a value to them.</p>

                    <h3>Common Data Types:</h3>
                    <pre>
int     → whole numbers             (e.g. 5, -3, 100)
float   → decimal numbers           (e.g. 3.14, -0.5)
str     → text / string             (e.g. "Hello", 'World')
bool    → True or False             (note: capital T and F)
list    → ordered, mutable sequence (e.g. [1, 2, 3])
tuple   → ordered, immutable        (e.g. (1, 2, 3))
dict    → key-value pairs           (e.g. {"name": "Alice"})
NoneType→ absence of value          (None)
</pre>

                    <h3>Declaring Variables:</h3>
                    <pre>
age = 20
price = 99.99
is_active = True
name = "Alice"
nothing = None

# Multiple assignment
x, y, z = 1, 2, 3

# Same value to multiple variables
a = b = c = 0
</pre>

                    <h3>Checking Types with type():</h3>
                    <pre>
print(type(42))        # &lt;class 'int'&gt;
print(type(3.14))      # &lt;class 'float'&gt;
print(type("hello"))   # &lt;class 'str'&gt;
print(type(True))      # &lt;class 'bool'&gt;
print(type(None))      # &lt;class 'NoneType'&gt;
</pre>

                    <h3>Reading Input from the User:</h3>
                    <pre>
# input() ALWAYS returns a string
name = input("Enter your name: ")
print("Hello,", name)

# Convert to int or float for numbers
age = int(input("Enter your age: "))
gpa = float(input("Enter your GPA: "))

print(f"Name: {name}, Age: {age}, GPA: {gpa}")
</pre>

                    <h3>Type Conversion (Casting):</h3>
                    <pre>
# Explicit conversion
int("42")          # → 42
float("3.14")      # → 3.14
str(100)           # → "100"
bool(0)            # → False
bool(1)            # → True
bool("")           # → False  (empty string is falsy)
bool("hello")      # → True   (non-empty string is truthy)

# Common pattern for numeric input
num = int(input("Enter a number: "))
</pre>

                    <h3>F-Strings (Formatted String Literals):</h3>
                    <pre>
name = "Alice"
age = 20
gpa = 3.75

# f-string (Python 3.6+) — recommended
print(f"Name: {name}, Age: {age}, GPA: {gpa:.2f}")
# Output: Name: Alice, Age: 20, GPA: 3.75

# .2f = format float to 2 decimal places
pi = 3.14159
print(f"Pi is approximately {pi:.2f}")  # 3.14
</pre>

                    <h3>String Methods:</h3>
                    <pre>
s = "hello world"

s.upper()          # "HELLO WORLD"
s.lower()          # "hello world"
s.title()          # "Hello World"
s.strip()          # removes leading/trailing whitespace
s.replace("hello", "hi")  # "hi world"
s.split(" ")       # ["hello", "world"]
len(s)             # 11
s[0]               # "h"   (indexing)
s[-1]              # "d"   (last character)
s[0:5]             # "hello" (slicing)
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Variable names are <b>case-sensitive</b>: <code>name</code> and <code>Name</code> are different.</li>
                        <li>Use <b>snake_case</b> for variable names in Python (e.g. <code>first_name</code>, <code>total_score</code>).</li>
                        <li><code>True</code> and <code>False</code> must be capitalized — <code>true</code> and <code>false</code> are NOT valid in Python.</li>
                        <li><code>input()</code> always returns a <code>str</code> — always convert with <code>int()</code> or <code>float()</code> when doing math.</li>
                    </ul>

                    <form method="GET" action="{{ route('py.lesson2.quiz') }}">
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
                    <h2 id="lesson3">Lesson 3: Control Flow — If-Else and Loops</h2>

                    <p>Python uses <code>if</code>, <code>elif</code>, and <code>else</code> for conditional logic. Unlike C or Java, Python does NOT use curly braces — it uses <b>indentation</b> to define code blocks. Python also has <code>for</code> and <code>while</code> loops with a unique <code>else</code> clause for loops.</p>

                    <h3>Basic if-elif-else Syntax:</h3>
                    <pre>
if condition:
    # runs if condition is True
elif another_condition:
    # runs if above is False and this is True
else:
    # runs if all conditions are False
</pre>

                    <h3>Example — Pass or Fail:</h3>
                    <pre>
score = int(input("Enter your score: "))

if score >= 75:
    print("You PASSED!")
else:
    print("You FAILED!")
</pre>

                    <h3>Example — Grade Classification:</h3>
                    <pre>
if score >= 90:
    print("Grade: A")
elif score >= 80:
    print("Grade: B")
elif score >= 70:
    print("Grade: C")
elif score >= 60:
    print("Grade: D")
else:
    print("Grade: F")
</pre>

                    <h3>Comparison and Logical Operators:</h3>
                    <pre>
# Comparison
==   → equal to
!=   → not equal to
>    → greater than
&lt;    → less than
>=   → greater than or equal
&lt;=   → less than or equal

# Logical
and  → both must be True
or   → at least one must be True
not  → reverses the condition
</pre>

                    <h3>Example — Logical Operators:</h3>
                    <pre>
age = int(input("Enter age: "))

if age >= 18 and age &lt;= 65:
    print("You are of working age.")
else:
    print("Outside working age range.")
</pre>

                    <h3>For Loop:</h3>
                    <pre>
# Iterates over a sequence (list, string, range, etc.)
for i in range(1, 6):   # range(start, stop) — stop is exclusive
    print(i)
# Output: 1 2 3 4 5

# range(stop)
for i in range(5):      # 0, 1, 2, 3, 4
    print(i)

# range(start, stop, step)
for i in range(0, 10, 2):   # 0, 2, 4, 6, 8
    print(i)
</pre>

                    <h3>Iterating Over a List or String:</h3>
                    <pre>
fruits = ["apple", "banana", "cherry"]
for fruit in fruits:
    print(fruit)

for char in "Python":
    print(char)
</pre>

                    <h3>While Loop:</h3>
                    <pre>
i = 1
while i &lt;= 5:
    print(i)
    i += 1
</pre>

                    <h3>break and continue:</h3>
                    <pre>
# break — exits the loop immediately
for i in range(1, 11):
    if i == 5:
        break
    print(i)
# Prints 1 2 3 4 then stops

# continue — skips the rest of the current iteration
for i in range(1, 6):
    if i == 3:
        continue
    print(i)
# Prints 1 2 4 5 (skips 3)
</pre>

                    <h3>Nested Loops and Patterns:</h3>
                    <pre>
# Right Triangle Pattern
n = 5
for i in range(1, n + 1):
    for j in range(i):
        print("*", end=" ")
    print()

# Output:
# *
# * *
# * * *
# * * * *
# * * * * *

# Square Pattern
n = 4
for i in range(n):
    for j in range(n):
        print("*", end=" ")
    print()
</pre>

                    <h3>Ternary Expression (One-line if-else):</h3>
                    <pre>
age = 20
result = "Adult" if age >= 18 else "Minor"
print(result)   # Adult
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Python uses <code>elif</code>, NOT <code>else if</code> (that's two words in C/C++/Java).</li>
                        <li>Indentation is <b>mandatory</b> — use 4 spaces consistently.</li>
                        <li><code>range(stop)</code> starts at 0. <code>range(1, 6)</code> gives 1, 2, 3, 4, 5 (not 6).</li>
                        <li>Python has no <code>switch</code> statement (until Python 3.10's <code>match</code>).</li>
                        <li>Use <code>print(value, end="")</code> to prevent a new line after each print.</li>
                    </ul>

                    <form method="GET" action="{{ route('py.lesson3.quiz') }}">
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
                    <h2 id="lesson4">Lesson 4: Functions and Collections</h2>

                    <p>Functions let you organize code into reusable blocks. Python also has powerful built-in collection types — <b>lists</b>, <b>tuples</b>, <b>dictionaries</b>, and <b>sets</b> — that make data management expressive and concise.</p>

                    <h2>Lesson 4.1: Functions</h2>
                    <pre>
def function_name(parameters):
    # function body
    return value
</pre>

                    <h3>Example:</h3>
                    <pre>
def greet(name):
    return f"Hello, {name}!"

message = greet("Alice")
print(message)   # Hello, Alice!
</pre>

                    <h3>Default Parameters:</h3>
                    <pre>
def greet(name, greeting="Hello"):
    return f"{greeting}, {name}!"

print(greet("Alice"))            # Hello, Alice!
print(greet("Bob", "Hi"))        # Hi, Bob!
</pre>

                    <h3>Multiple Return Values:</h3>
                    <pre>
def min_max(numbers):
    return min(numbers), max(numbers)

low, high = min_max([3, 1, 4, 1, 5, 9])
print(low, high)   # 1 9
</pre>

                    <h3>*args and **kwargs:</h3>
                    <pre>
# *args — accepts any number of positional arguments
def add(*numbers):
    return sum(numbers)

print(add(1, 2, 3))       # 6
print(add(10, 20, 30, 40)) # 100

# **kwargs — accepts any number of keyword arguments
def show_info(**info):
    for key, value in info.items():
        print(f"{key}: {value}")

show_info(name="Alice", age=20, city="Manila")
</pre>

                    <h2>Lesson 4.2: Lists</h2>
                    <pre>
# Creating a list
fruits = ["apple", "banana", "cherry"]
numbers = [1, 2, 3, 4, 5]
mixed  = [1, "hello", True, 3.14]

# Indexing (zero-based)
fruits[0]    # "apple"
fruits[-1]   # "cherry"  (last item)

# Slicing
fruits[0:2]  # ["apple", "banana"]

# Common list methods
fruits.append("mango")       # adds to end
fruits.insert(1, "grape")    # inserts at index
fruits.remove("banana")      # removes first occurrence
fruits.pop()                 # removes and returns last item
fruits.sort()                # sorts in place
fruits.reverse()             # reverses in place
len(fruits)                  # number of items

# List comprehension
squares = [x**2 for x in range(1, 6)]
# [1, 4, 9, 16, 25]

evens = [x for x in range(10) if x % 2 == 0]
# [0, 2, 4, 6, 8]
</pre>

                    <h2>Lesson 4.3: Tuples</h2>
                    <pre>
# Tuples are immutable (cannot be changed after creation)
coordinates = (10.5, 20.3)
colors = ("red", "green", "blue")

coordinates[0]    # 10.5
# coordinates[0] = 5  → TypeError: tuple is immutable

# Tuple unpacking
x, y = coordinates
print(x, y)   # 10.5  20.3

# Single-element tuple (must have trailing comma)
single = (42,)    # this is a tuple
not_tuple = (42)  # this is just an int
</pre>

                    <h2>Lesson 4.4: Dictionaries</h2>
                    <pre>
# Key-value pairs
student = {
    "name": "Alice",
    "age": 20,
    "gpa": 3.75
}

# Accessing values
student["name"]          # "Alice"
student.get("age")       # 20
student.get("email", "N/A")  # "N/A" (default if key missing)

# Adding / updating
student["email"] = "alice@email.com"
student["age"] = 21

# Removing
del student["gpa"]
student.pop("age")

# Iterating
for key, value in student.items():
    print(f"{key}: {value}")

# Useful dict methods
student.keys()     # dict_keys(["name", "email"])
student.values()   # dict_values(["Alice", "alice@email.com"])
"name" in student  # True
</pre>

                    <h2>Lesson 4.5: Sets</h2>
                    <pre>
# Unordered, no duplicates
my_set = {1, 2, 3, 3, 2}
print(my_set)   # {1, 2, 3}

my_set.add(4)
my_set.remove(2)

# Set operations
a = {1, 2, 3}
b = {2, 3, 4}

a | b    # union:        {1, 2, 3, 4}
a &amp; b    # intersection: {2, 3}
a - b    # difference:   {1}
</pre>

                    <h3>Comparison — When to Use Each Collection:</h3>
                    <pre>
list   → ordered, mutable, allows duplicates     (most common)
tuple  → ordered, immutable, allows duplicates   (fixed data)
dict   → key-value pairs, fast lookup            (structured data)
set    → unordered, no duplicates, fast lookup   (unique items)
</pre>

                    <form method="GET" action="{{ route('py.lesson4.quiz') }}">
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
                    <h2 id="lesson5">Lesson 5: Object-Oriented Programming in Python</h2>

                    <p>Python supports full Object-Oriented Programming. Everything in Python is an object. The four pillars of OOP — <b>Encapsulation</b>, <b>Inheritance</b>, <b>Polymorphism</b>, and <b>Abstraction</b> — are all supported. Python's syntax for OOP is simpler and more readable compared to C++ and Java.</p>

                    <h3>Classes and Objects:</h3>
                    <pre>
class Dog:
    # Class variable (shared by all instances)
    species = "Canis lupus familiaris"

    # Constructor (__init__ is the initializer)
    def __init__(self, name, age):
        # Instance variables
        self.name = name
        self.age  = age

    # Instance method
    def bark(self):
        print(f"{self.name} says: Woof!")

    def describe(self):
        print(f"{self.name} is {self.age} years old.")

# Creating objects
d1 = Dog("Buddy", 3)
d2 = Dog("Max", 5)

d1.bark()       # Buddy says: Woof!
d2.describe()   # Max is 5 years old.
print(Dog.species)  # Canis lupus familiaris
</pre>

                    <h3>The self Parameter:</h3>
                    <pre>
# self refers to the current object instance
# It must be the first parameter in every instance method
# Python passes it automatically — you don't call it with self

d1.bark()   # Python internally calls Dog.bark(d1)
</pre>

                    <h3>Encapsulation — Private Attributes:</h3>
                    <pre>
class Person:
    def __init__(self, name, age):
        self._name  = name    # convention: protected (single underscore)
        self.__age  = age     # name-mangled: private (double underscore)

    # Getter
    def get_name(self):
        return self._name

    def get_age(self):
        return self.__age

    # Setter with validation
    def set_age(self, age):
        if age >= 0:
            self.__age = age

p = Person("Alice", 20)
print(p.get_name())   # Alice
p.set_age(21)
</pre>

                    <h3>Using @property (Pythonic getters/setters):</h3>
                    <pre>
class Circle:
    def __init__(self, radius):
        self.__radius = radius

    @property
    def radius(self):
        return self.__radius

    @radius.setter
    def radius(self, value):
        if value &gt; 0:
            self.__radius = value

    @property
    def area(self):
        return 3.14159 * self.__radius ** 2

c = Circle(5)
print(c.radius)     # 5
print(c.area)       # 78.53975
c.radius = 10       # uses the setter
</pre>

                    <h3>Inheritance:</h3>
                    <pre>
class Animal:
    def __init__(self, name):
        self.name = name

    def speak(self):
        print("...")

class Dog(Animal):   # Dog inherits from Animal
    def speak(self):          # Method overriding
        print(f"{self.name} says: Woof!")

class Cat(Animal):
    def speak(self):
        print(f"{self.name} says: Meow!")

d = Dog("Buddy")
c = Cat("Whiskers")
d.speak()   # Buddy says: Woof!
c.speak()   # Whiskers says: Meow!
</pre>

                    <h3>super() — Calling the Parent Constructor:</h3>
                    <pre>
class Animal:
    def __init__(self, name, age):
        self.name = name
        self.age  = age

class Dog(Animal):
    def __init__(self, name, age, breed):
        super().__init__(name, age)   # calls Animal.__init__
        self.breed = breed

d = Dog("Rex", 4, "Labrador")
print(d.name, d.age, d.breed)   # Rex 4 Labrador
</pre>

                    <h3>Polymorphism:</h3>
                    <pre>
# Same function works with different object types
animals = [Dog("Buddy"), Cat("Whiskers"), Dog("Max")]

for animal in animals:
    animal.speak()    # calls the correct speak() for each type
</pre>

                    <h3>Abstract Classes:</h3>
                    <pre>
from abc import ABC, abstractmethod

class Shape(ABC):
    @abstractmethod
    def area(self):
        pass    # subclasses MUST implement this

class Rectangle(Shape):
    def __init__(self, w, h):
        self.w = w
        self.h = h

    def area(self):
        return self.w * self.h

class Circle(Shape):
    def __init__(self, r):
        self.r = r

    def area(self):
        return 3.14159 * self.r ** 2

r = Rectangle(4, 5)
c = Circle(3)
print(r.area())   # 20
print(c.area())   # 28.27431

# Shape()  → TypeError: Can't instantiate abstract class
</pre>

                    <h3>Magic / Dunder Methods:</h3>
                    <pre>
class Point:
    def __init__(self, x, y):
        self.x = x
        self.y = y

    def __str__(self):          # called by print()
        return f"Point({self.x}, {self.y})"

    def __add__(self, other):   # called by + operator
        return Point(self.x + other.x, self.y + other.y)

    def __len__(self):          # called by len()
        return 2

p1 = Point(1, 2)
p2 = Point(3, 4)
print(p1)           # Point(1, 2)
print(p1 + p2)      # Point(4, 6)
print(len(p1))      # 2
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Every instance method must have <code>self</code> as its first parameter.</li>
                        <li>Use <code>__init__</code> as the constructor (not the class name like in C++/Java).</li>
                        <li>Python does not have true <code>private</code> — use <code>__name</code> for name mangling or <code>_name</code> by convention.</li>
                        <li>Python supports multiple inheritance: <code>class Duck(Flyable, Swimmable):</code></li>
                        <li>Import <code>ABC</code> and <code>abstractmethod</code> from <code>abc</code> module for abstract classes.</li>
                        <li>Dunder (double underscore) methods like <code>__str__</code>, <code>__add__</code> enable operator overloading.</li>
                    </ul>

                    <form method="GET" action="{{ route('py.lesson5.quiz') }}">
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
                    <form method="GET" action="{{ route('py.final.exam') }}">
                        <button>Take Final Exam</button>
                    </form>
                @endif

            @endif {{-- end !$showQuiz --}}


            {{-- ============================================================ --}}
            {{-- QUIZ SECTIONS                                                --}}
            {{-- ============================================================ --}}

            @if ($showQuiz === true)
                {{-- ── Lesson 1 Quiz ── --}}
                <h2>Lesson 1 Quiz — Introduction to Python</h2>
                <form method="POST" action="{{ route('py.submit') }}">
                    @csrf

                    <p>1. Who created Python?</p>
                    <input type="radio" name="q1" value="a"> A. Dennis Ritchie<br>
                    <input type="radio" name="q1" value="b"> B. Guido van Rossum<br>
                    <input type="radio" name="q1" value="c"> C. Bjarne Stroustrup<br>
                    <input type="radio" name="q1" value="d"> D. James Gosling<br><br>

                    <p>2. When was Python first released?</p>
                    <input type="radio" name="q2" value="a"> A. 1983<br>
                    <input type="radio" name="q2" value="b"> B. 1995<br>
                    <input type="radio" name="q2" value="c"> C. 1991<br>
                    <input type="radio" name="q2" value="d"> D. 2000<br><br>

                    <p>3. Which function outputs text to the screen in Python?</p>
                    <input type="radio" name="q3" value="a"> A. cout<br>
                    <input type="radio" name="q3" value="b"> B. echo<br>
                    <input type="radio" name="q3" value="c"> C. printf<br>
                    <input type="radio" name="q3" value="d"> D. print<br><br>

                    <p>4. How are code blocks defined in Python?</p>
                    <input type="radio" name="q4" value="a"> A. Using curly braces { }<br>
                    <input type="radio" name="q4" value="b"> B. Using BEGIN and END keywords<br>
                    <input type="radio" name="q4" value="c"> C. Using indentation<br>
                    <input type="radio" name="q4" value="d"> D. Using parentheses<br><br>

                    <p>5. How do you write a single-line comment in Python?</p>
                    <input type="radio" name="q5" value="a"> A. // comment<br>
                    <input type="radio" name="q5" value="b"> B. /* comment */<br>
                    <input type="radio" name="q5" value="c"> C. # comment<br>
                    <input type="radio" name="q5" value="d"> D. &lt;!-- comment --&gt;<br><br>

                    <p>6. Which Python version is currently recommended for new projects?</p>
                    <input type="radio" name="q6" value="a"> A. Python 1<br>
                    <input type="radio" name="q6" value="b"> B. Python 2<br>
                    <input type="radio" name="q6" value="c"> C. Python 3<br>
                    <input type="radio" name="q6" value="d"> D. Python 4<br><br>

                    <p>7. What escape sequence moves the cursor to a new line?</p>
                    <input type="radio" name="q7" value="a"> A. \t<br>
                    <input type="radio" name="q7" value="b"> B. \n<br>
                    <input type="radio" name="q7" value="c"> C. \r<br>
                    <input type="radio" name="q7" value="d"> D. \b<br><br>

                    <p>8. Python is described as what type of language regarding typing?</p>
                    <input type="radio" name="q8" value="a"> A. Statically typed<br>
                    <input type="radio" name="q8" value="b"> B. Dynamically typed<br>
                    <input type="radio" name="q8" value="c"> C. Strongly compiled<br>
                    <input type="radio" name="q8" value="d"> D. Weakly typed<br><br>

                    <p>9. What is the correct file extension for a Python source file?</p>
                    <input type="radio" name="q9" value="a"> A. .java<br>
                    <input type="radio" name="q9" value="b"> B. .cpp<br>
                    <input type="radio" name="q9" value="c"> C. .py<br>
                    <input type="radio" name="q9" value="d"> D. .pyt<br><br>

                    <p>10. Which of the following correctly prints a tab space in Python?</p>
                    <input type="radio" name="q10" value="a"> A. print("\n")<br>
                    <input type="radio" name="q10" value="b"> B. print("\t")<br>
                    <input type="radio" name="q10" value="c"> C. print("\b")<br>
                    <input type="radio" name="q10" value="d"> D. print("\r")<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson2')
                {{-- ── Lesson 2 Quiz ── --}}
                <h2>Lesson 2 Quiz — Variables, Data Types, and Input</h2>
                <form method="POST" action="{{ route('py.lesson2.submit') }}">
                    @csrf

                    <p>1. Which Python function reads input from the user?</p>
                    <input type="radio" name="q1" value="a"> A. read()<br>
                    <input type="radio" name="q1" value="b"> B. scan()<br>
                    <input type="radio" name="q1" value="c"> C. cin<br>
                    <input type="radio" name="q1" value="d"> D. input()<br><br>

                    <p>2. What does input() always return?</p>
                    <input type="radio" name="q2" value="a"> A. int<br>
                    <input type="radio" name="q2" value="b"> B. float<br>
                    <input type="radio" name="q2" value="c"> C. str<br>
                    <input type="radio" name="q2" value="d"> D. bool<br><br>

                    <p>3. Which data type stores True or False in Python?</p>
                    <input type="radio" name="q3" value="a"> A. int<br>
                    <input type="radio" name="q3" value="b"> B. boolean<br>
                    <input type="radio" name="q3" value="c"> C. bool<br>
                    <input type="radio" name="q3" value="d"> D. bit<br><br>

                    <p>4. What does type(3.14) return?</p>
                    <input type="radio" name="q4" value="a"> A. &lt;class 'int'&gt;<br>
                    <input type="radio" name="q4" value="b"> B. &lt;class 'double'&gt;<br>
                    <input type="radio" name="q4" value="c"> C. &lt;class 'float'&gt;<br>
                    <input type="radio" name="q4" value="d"> D. &lt;class 'decimal'&gt;<br><br>

                    <p>5. Which is the correct f-string syntax in Python?</p>
                    <input type="radio" name="q5" value="a"> A. "Hello, {name}"<br>
                    <input type="radio" name="q5" value="b"> B. f"Hello, {name}"<br>
                    <input type="radio" name="q5" value="c"> C. f'Hello, ' + name<br>
                    <input type="radio" name="q5" value="d"> D. format("Hello, name")<br><br>

                    <p>6. What is the naming convention for variables in Python?</p>
                    <input type="radio" name="q6" value="a"> A. camelCase<br>
                    <input type="radio" name="q6" value="b"> B. PascalCase<br>
                    <input type="radio" name="q6" value="c"> C. snake_case<br>
                    <input type="radio" name="q6" value="d"> D. UPPER_CASE<br><br>

                    <p>7. How do you correctly convert the string "42" to an integer?</p>
                    <input type="radio" name="q7" value="a"> A. convert("42")<br>
                    <input type="radio" name="q7" value="b"> B. stoi("42")<br>
                    <input type="radio" name="q7" value="c"> C. int("42")<br>
                    <input type="radio" name="q7" value="d"> D. Integer("42")<br><br>

                    <p>8. What does bool("") return in Python?</p>
                    <input type="radio" name="q8" value="a"> A. True<br>
                    <input type="radio" name="q8" value="b"> B. False<br>
                    <input type="radio" name="q8" value="c"> C. None<br>
                    <input type="radio" name="q8" value="d"> D. Error<br><br>

                    <p>9. Which method converts a string to uppercase in Python?</p>
                    <input type="radio" name="q9" value="a"> A. s.toUpper()<br>
                    <input type="radio" name="q9" value="b"> B. s.uppercase()<br>
                    <input type="radio" name="q9" value="c"> C. s.upper()<br>
                    <input type="radio" name="q9" value="d"> D. upper(s)<br><br>

                    <p>10. In Python, True and False must be written as?</p>
                    <input type="radio" name="q10" value="a"> A. true and false (lowercase)<br>
                    <input type="radio" name="q10" value="b"> B. TRUE and FALSE (all caps)<br>
                    <input type="radio" name="q10" value="c"> C. True and False (capitalized)<br>
                    <input type="radio" name="q10" value="d"> D. 1 and 0 only<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson3')
                {{-- ── Lesson 3 Quiz ── --}}
                <h2>Lesson 3 Quiz — Control Flow and Loops</h2>
                <form method="POST" action="{{ route('py.lesson3.submit') }}">
                    @csrf

                    <p>1. In Python, "else if" is written as?</p>
                    <input type="radio" name="q1" value="a"> A. else if<br>
                    <input type="radio" name="q1" value="b"> B. elseif<br>
                    <input type="radio" name="q1" value="c"> C. elif<br>
                    <input type="radio" name="q1" value="d"> D. otherwise<br><br>

                    <p>2. What does range(5) produce?</p>
                    <input type="radio" name="q2" value="a"> A. 1, 2, 3, 4, 5<br>
                    <input type="radio" name="q2" value="b"> B. 0, 1, 2, 3, 4<br>
                    <input type="radio" name="q2" value="c"> C. 0, 1, 2, 3, 4, 5<br>
                    <input type="radio" name="q2" value="d"> D. 1, 2, 3, 4<br><br>

                    <p>3. What keyword immediately exits a loop in Python?</p>
                    <input type="radio" name="q3" value="a"> A. exit<br>
                    <input type="radio" name="q3" value="b"> B. stop<br>
                    <input type="radio" name="q3" value="c"> C. break<br>
                    <input type="radio" name="q3" value="d"> D. return<br><br>

                    <p>4. What keyword skips the current iteration of a loop?</p>
                    <input type="radio" name="q4" value="a"> A. skip<br>
                    <input type="radio" name="q4" value="b"> B. next<br>
                    <input type="radio" name="q4" value="c"> C. continue<br>
                    <input type="radio" name="q4" value="d"> D. pass<br><br>

                    <p>5. What does the logical operator "and" require?</p>
                    <input type="radio" name="q5" value="a"> A. At least one condition to be True<br>
                    <input type="radio" name="q5" value="b"> B. Both conditions to be True<br>
                    <input type="radio" name="q5" value="c"> C. Neither condition to be True<br>
                    <input type="radio" name="q5" value="d"> D. One condition to be False<br><br>

                    <p>6. What does range(1, 10, 2) produce?</p>
                    <input type="radio" name="q6" value="a"> A. 1, 2, 3, 4, 5, 6, 7, 8, 9<br>
                    <input type="radio" name="q6" value="b"> B. 2, 4, 6, 8, 10<br>
                    <input type="radio" name="q6" value="c"> C. 1, 3, 5, 7, 9<br>
                    <input type="radio" name="q6" value="d"> D. 1, 3, 5, 7, 9, 11<br><br>

                    <p>7. Which is the correct ternary expression in Python?</p>
                    <input type="radio" name="q7" value="a"> A. age >= 18 ? "Adult" : "Minor"<br>
                    <input type="radio" name="q7" value="b"> B. if age >= 18 then "Adult" else "Minor"<br>
                    <input type="radio" name="q7" value="c"> C. "Adult" if age >= 18 else "Minor"<br>
                    <input type="radio" name="q7" value="d"> D. (age >= 18) && "Adult" || "Minor"<br><br>

                    <p>8. In Python, how do you print without a new line at the end?</p>
                    <input type="radio" name="q8" value="a"> A. print(value, end="\n")<br>
                    <input type="radio" name="q8" value="b"> B. print(value, end="")<br>
                    <input type="radio" name="q8" value="c"> C. println(value)<br>
                    <input type="radio" name="q8" value="d"> D. print_no_nl(value)<br><br>

                    <p>9. Which Python version introduced the match statement (like switch)?</p>
                    <input type="radio" name="q9" value="a"> A. Python 3.6<br>
                    <input type="radio" name="q9" value="b"> B. Python 3.8<br>
                    <input type="radio" name="q9" value="c"> C. Python 3.10<br>
                    <input type="radio" name="q9" value="d"> D. Python 3.12<br><br>

                    <p>10. What does the "not" operator do in Python?</p>
                    <input type="radio" name="q10" value="a"> A. Compares two values<br>
                    <input type="radio" name="q10" value="b"> B. Adds two values<br>
                    <input type="radio" name="q10" value="c"> C. Reverses a boolean condition<br>
                    <input type="radio" name="q10" value="d"> D. Returns None<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson4')
                {{-- ── Lesson 4 Quiz ── --}}
                <h2>Lesson 4 Quiz — Functions and Collections</h2>
                <form method="POST" action="{{ route('py.lesson4.submit') }}">
                    @csrf

                    <p>1. Which keyword defines a function in Python?</p>
                    <input type="radio" name="q1" value="a"> A. function<br>
                    <input type="radio" name="q1" value="b"> B. func<br>
                    <input type="radio" name="q1" value="c"> C. def<br>
                    <input type="radio" name="q1" value="d"> D. fn<br><br>

                    <p>2. Which collection type is IMMUTABLE in Python?</p>
                    <input type="radio" name="q2" value="a"> A. list<br>
                    <input type="radio" name="q2" value="b"> B. dict<br>
                    <input type="radio" name="q2" value="c"> C. set<br>
                    <input type="radio" name="q2" value="d"> D. tuple<br><br>

                    <p>3. Which method adds an item to the end of a list?</p>
                    <input type="radio" name="q3" value="a"> A. list.add()<br>
                    <input type="radio" name="q3" value="b"> B. list.push()<br>
                    <input type="radio" name="q3" value="c"> C. list.append()<br>
                    <input type="radio" name="q3" value="d"> D. list.insert()<br><br>

                    <p>4. What does *args allow in a Python function?</p>
                    <input type="radio" name="q4" value="a"> A. Any number of keyword arguments<br>
                    <input type="radio" name="q4" value="b"> B. Any number of positional arguments<br>
                    <input type="radio" name="q4" value="c"> C. Only two arguments<br>
                    <input type="radio" name="q4" value="d"> D. No arguments<br><br>

                    <p>5. What is a list comprehension?</p>
                    <input type="radio" name="q5" value="a"> A. A way to sort a list<br>
                    <input type="radio" name="q5" value="b"> B. A concise way to create a list using a for loop in one line<br>
                    <input type="radio" name="q5" value="c"> C. A method to delete items from a list<br>
                    <input type="radio" name="q5" value="d"> D. A way to merge two lists<br><br>

                    <p>6. Which collection stores key-value pairs in Python?</p>
                    <input type="radio" name="q6" value="a"> A. list<br>
                    <input type="radio" name="q6" value="b"> B. tuple<br>
                    <input type="radio" name="q6" value="c"> C. set<br>
                    <input type="radio" name="q6" value="d"> D. dict<br><br>

                    <p>7. What does [x**2 for x in range(1, 4)] produce?</p>
                    <input type="radio" name="q7" value="a"> A. [1, 2, 3]<br>
                    <input type="radio" name="q7" value="b"> B. [2, 4, 6]<br>
                    <input type="radio" name="q7" value="c"> C. [1, 4, 9]<br>
                    <input type="radio" name="q7" value="d"> D. [1, 8, 27]<br><br>

                    <p>8. Sets in Python do NOT allow?</p>
                    <input type="radio" name="q8" value="a"> A. Mixed types<br>
                    <input type="radio" name="q8" value="b"> B. Integers<br>
                    <input type="radio" name="q8" value="c"> C. Duplicate values<br>
                    <input type="radio" name="q8" value="d"> D. Strings<br><br>

                    <p>9. What does dict.get("key", "default") return when the key is missing?</p>
                    <input type="radio" name="q9" value="a"> A. None<br>
                    <input type="radio" name="q9" value="b"> B. Error<br>
                    <input type="radio" name="q9" value="c"> C. "default"<br>
                    <input type="radio" name="q9" value="d"> D. 0<br><br>

                    <p>10. What does **kwargs allow in a function?</p>
                    <input type="radio" name="q10" value="a"> A. Any number of positional arguments<br>
                    <input type="radio" name="q10" value="b"> B. Any number of keyword arguments<br>
                    <input type="radio" name="q10" value="c"> C. Only default arguments<br>
                    <input type="radio" name="q10" value="d"> D. No arguments<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson5')
                {{-- ── Lesson 5 Quiz ── --}}
                <h2>Lesson 5 Quiz — Object-Oriented Programming</h2>
                <form method="POST" action="{{ route('py.lesson5.submit') }}">
                    @csrf

                    <p>1. What keyword defines a class in Python?</p>
                    <input type="radio" name="q1" value="a"> A. object<br>
                    <input type="radio" name="q1" value="b"> B. class<br>
                    <input type="radio" name="q1" value="c"> C. struct<br>
                    <input type="radio" name="q1" value="d"> D. type<br><br>

                    <p>2. What is the Python class constructor method called?</p>
                    <input type="radio" name="q2" value="a"> A. __constructor__<br>
                    <input type="radio" name="q2" value="b"> B. __new__<br>
                    <input type="radio" name="q2" value="c"> C. __init__<br>
                    <input type="radio" name="q2" value="d"> D. __create__<br><br>

                    <p>3. What does "self" refer to in a Python method?</p>
                    <input type="radio" name="q3" value="a"> A. The parent class<br>
                    <input type="radio" name="q3" value="b"> B. The current object instance<br>
                    <input type="radio" name="q3" value="c"> C. A static member<br>
                    <input type="radio" name="q3" value="d"> D. The class itself<br><br>

                    <p>4. What convention marks a "private" attribute in Python?</p>
                    <input type="radio" name="q4" value="a"> A. Single underscore prefix: _name<br>
                    <input type="radio" name="q4" value="b"> B. Double underscore prefix: __name<br>
                    <input type="radio" name="q4" value="c"> C. Using the private keyword<br>
                    <input type="radio" name="q4" value="d"> D. ALL_CAPS naming<br><br>

                    <p>5. Which syntax is used to inherit from a parent class in Python?</p>
                    <input type="radio" name="q5" value="a"> A. class Dog extends Animal:<br>
                    <input type="radio" name="q5" value="b"> B. class Dog implements Animal:<br>
                    <input type="radio" name="q5" value="c"> C. class Dog(Animal):<br>
                    <input type="radio" name="q5" value="d"> D. class Dog : Animal:<br><br>

                    <p>6. Which function calls the parent class constructor in Python?</p>
                    <input type="radio" name="q6" value="a"> A. parent().__init__()<br>
                    <input type="radio" name="q6" value="b"> B. super().__init__()<br>
                    <input type="radio" name="q6" value="c"> C. base().__init__()<br>
                    <input type="radio" name="q6" value="d"> D. this.__init__()<br><br>

                    <p>7. What modules are needed to create an abstract class in Python?</p>
                    <input type="radio" name="q7" value="a"> A. import abstract<br>
                    <input type="radio" name="q7" value="b"> B. from abstract import ABC<br>
                    <input type="radio" name="q7" value="c"> C. from abc import ABC, abstractmethod<br>
                    <input type="radio" name="q7" value="d"> D. import abc.class<br><br>

                    <p>8. What is the dunder method __str__ used for?</p>
                    <input type="radio" name="q8" value="a"> A. Converting a string to an object<br>
                    <input type="radio" name="q8" value="b"> B. Defining how the object is represented as a string (called by print())<br>
                    <input type="radio" name="q8" value="c"> C. Counting string length<br>
                    <input type="radio" name="q8" value="d"> D. Comparing two strings<br><br>

                    <p>9. Python supports multiple inheritance. Which syntax is correct?</p>
                    <input type="radio" name="q9" value="a"> A. class Duck extends Flyable, Swimmable:<br>
                    <input type="radio" name="q9" value="b"> B. class Duck(Flyable, Swimmable):<br>
                    <input type="radio" name="q9" value="c"> C. class Duck implements Flyable and Swimmable:<br>
                    <input type="radio" name="q9" value="d"> D. class Duck: Flyable, Swimmable<br><br>

                    <p>10. What decorator is used to create a getter in Python's property system?</p>
                    <input type="radio" name="q10" value="a"> A. @getter<br>
                    <input type="radio" name="q10" value="b"> B. @staticmethod<br>
                    <input type="radio" name="q10" value="c"> C. @property<br>
                    <input type="radio" name="q10" value="d"> D. @classmethod<br><br>

                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'final')
                {{-- ── Final Exam (50 questions) ── --}}
                <h2>🎓 Python Programming Final Exam</h2>
                <p>This exam covers all lessons. Answer all 50 questions.</p>

                <form method="POST" action="{{ route('py.final.submit') }}">
                    @csrf

                    <h3>— Introduction to Python (Q1–10) —</h3>

                    <p>1. Who created Python?</p>
                    <input type="radio" name="q1" value="a"> A. Dennis Ritchie<br>
                    <input type="radio" name="q1" value="b"> B. Guido van Rossum<br>
                    <input type="radio" name="q1" value="c"> C. Bjarne Stroustrup<br>
                    <input type="radio" name="q1" value="d"> D. James Gosling<br><br>

                    <p>2. When was Python first released?</p>
                    <input type="radio" name="q2" value="a"> A. 1983<br>
                    <input type="radio" name="q2" value="b"> B. 1991<br>
                    <input type="radio" name="q2" value="c"> C. 1995<br>
                    <input type="radio" name="q2" value="d"> D. 2000<br><br>

                    <p>3. Which function outputs text to the screen in Python?</p>
                    <input type="radio" name="q3" value="a"> A. cout<br>
                    <input type="radio" name="q3" value="b"> B. echo<br>
                    <input type="radio" name="q3" value="c"> C. print<br>
                    <input type="radio" name="q3" value="d"> D. printf<br><br>

                    <p>4. How are code blocks defined in Python?</p>
                    <input type="radio" name="q4" value="a"> A. Using curly braces { }<br>
                    <input type="radio" name="q4" value="b"> B. Using indentation<br>
                    <input type="radio" name="q4" value="c"> C. Using BEGIN and END<br>
                    <input type="radio" name="q4" value="d"> D. Using parentheses<br><br>

                    <p>5. How do you write a single-line comment in Python?</p>
                    <input type="radio" name="q5" value="a"> A. // comment<br>
                    <input type="radio" name="q5" value="b"> B. /* comment */<br>
                    <input type="radio" name="q5" value="c"> C. # comment<br>
                    <input type="radio" name="q5" value="d"> D. &lt;!-- comment --&gt;<br><br>

                    <p>6. Which Python version is recommended for new projects?</p>
                    <input type="radio" name="q6" value="a"> A. Python 1<br>
                    <input type="radio" name="q6" value="b"> B. Python 2<br>
                    <input type="radio" name="q6" value="c"> C. Python 3<br>
                    <input type="radio" name="q6" value="d"> D. Python 4<br><br>

                    <p>7. What escape sequence creates a new line?</p>
                    <input type="radio" name="q7" value="a"> A. \t<br>
                    <input type="radio" name="q7" value="b"> B. \b<br>
                    <input type="radio" name="q7" value="c"> C. \r<br>
                    <input type="radio" name="q7" value="d"> D. \n<br><br>

                    <p>8. Python is described as what type of language for typing?</p>
                    <input type="radio" name="q8" value="a"> A. Statically typed<br>
                    <input type="radio" name="q8" value="b"> B. Dynamically typed<br>
                    <input type="radio" name="q8" value="c"> C. Strongly compiled<br>
                    <input type="radio" name="q8" value="d"> D. Weakly typed<br><br>

                    <p>9. What is the correct file extension for Python?</p>
                    <input type="radio" name="q9" value="a"> A. .java<br>
                    <input type="radio" name="q9" value="b"> B. .cpp<br>
                    <input type="radio" name="q9" value="c"> C. .py<br>
                    <input type="radio" name="q9" value="d"> D. .pyt<br><br>

                    <p>10. Which prints a tab space in Python?</p>
                    <input type="radio" name="q10" value="a"> A. print("\n")<br>
                    <input type="radio" name="q10" value="b"> B. print("\t")<br>
                    <input type="radio" name="q10" value="c"> C. print("\b")<br>
                    <input type="radio" name="q10" value="d"> D. print("\r")<br><br>

                    <h3>— Variables, Data Types &amp; Input (Q11–20) —</h3>

                    <p>11. Which function reads input from the user in Python?</p>
                    <input type="radio" name="q11" value="a"> A. read()<br>
                    <input type="radio" name="q11" value="b"> B. scan()<br>
                    <input type="radio" name="q11" value="c"> C. input()<br>
                    <input type="radio" name="q11" value="d"> D. cin<br><br>

                    <p>12. What does input() always return?</p>
                    <input type="radio" name="q12" value="a"> A. int<br>
                    <input type="radio" name="q12" value="b"> B. float<br>
                    <input type="radio" name="q12" value="c"> C. str<br>
                    <input type="radio" name="q12" value="d"> D. bool<br><br>

                    <p>13. Which data type stores True or False in Python?</p>
                    <input type="radio" name="q13" value="a"> A. int<br>
                    <input type="radio" name="q13" value="b"> B. boolean<br>
                    <input type="radio" name="q13" value="c"> C. bool<br>
                    <input type="radio" name="q13" value="d"> D. bit<br><br>

                    <p>14. What does type(3.14) return?</p>
                    <input type="radio" name="q14" value="a"> A. &lt;class 'int'&gt;<br>
                    <input type="radio" name="q14" value="b"> B. &lt;class 'double'&gt;<br>
                    <input type="radio" name="q14" value="c"> C. &lt;class 'float'&gt;<br>
                    <input type="radio" name="q14" value="d"> D. &lt;class 'decimal'&gt;<br><br>

                    <p>15. Which is the correct f-string syntax?</p>
                    <input type="radio" name="q15" value="a"> A. "Hello, {name}"<br>
                    <input type="radio" name="q15" value="b"> B. f"Hello, {name}"<br>
                    <input type="radio" name="q15" value="c"> C. f'Hello, ' + name<br>
                    <input type="radio" name="q15" value="d"> D. format("Hello, name")<br><br>

                    <p>16. What is the Python naming convention for variables?</p>
                    <input type="radio" name="q16" value="a"> A. camelCase<br>
                    <input type="radio" name="q16" value="b"> B. PascalCase<br>
                    <input type="radio" name="q16" value="c"> C. snake_case<br>
                    <input type="radio" name="q16" value="d"> D. UPPER_CASE<br><br>

                    <p>17. How do you correctly convert "42" to an integer?</p>
                    <input type="radio" name="q17" value="a"> A. convert("42")<br>
                    <input type="radio" name="q17" value="b"> B. stoi("42")<br>
                    <input type="radio" name="q17" value="c"> C. int("42")<br>
                    <input type="radio" name="q17" value="d"> D. Integer("42")<br><br>

                    <p>18. What does bool("") return?</p>
                    <input type="radio" name="q18" value="a"> A. True<br>
                    <input type="radio" name="q18" value="b"> B. False<br>
                    <input type="radio" name="q18" value="c"> C. None<br>
                    <input type="radio" name="q18" value="d"> D. Error<br><br>

                    <p>19. Which method converts a string to uppercase?</p>
                    <input type="radio" name="q19" value="a"> A. s.toUpper()<br>
                    <input type="radio" name="q19" value="b"> B. s.uppercase()<br>
                    <input type="radio" name="q19" value="c"> C. s.upper()<br>
                    <input type="radio" name="q19" value="d"> D. upper(s)<br><br>

                    <p>20. True and False in Python must be?</p>
                    <input type="radio" name="q20" value="a"> A. lowercase (true/false)<br>
                    <input type="radio" name="q20" value="b"> B. ALL CAPS (TRUE/FALSE)<br>
                    <input type="radio" name="q20" value="c"> C. Capitalized (True/False)<br>
                    <input type="radio" name="q20" value="d"> D. 1 and 0 only<br><br>

                    <h3>— Control Flow &amp; Loops (Q21–30) —</h3>

                    <p>21. In Python, "else if" is written as?</p>
                    <input type="radio" name="q21" value="a"> A. else if<br>
                    <input type="radio" name="q21" value="b"> B. elseif<br>
                    <input type="radio" name="q21" value="c"> C. elif<br>
                    <input type="radio" name="q21" value="d"> D. otherwise<br><br>

                    <p>22. What does range(5) produce?</p>
                    <input type="radio" name="q22" value="a"> A. 1, 2, 3, 4, 5<br>
                    <input type="radio" name="q22" value="b"> B. 0, 1, 2, 3, 4<br>
                    <input type="radio" name="q22" value="c"> C. 0, 1, 2, 3, 4, 5<br>
                    <input type="radio" name="q22" value="d"> D. 1, 2, 3, 4<br><br>

                    <p>23. Keyword to immediately exit a loop?</p>
                    <input type="radio" name="q23" value="a"> A. exit<br>
                    <input type="radio" name="q23" value="b"> B. stop<br>
                    <input type="radio" name="q23" value="c"> C. break<br>
                    <input type="radio" name="q23" value="d"> D. return<br><br>

                    <p>24. Keyword to skip the current iteration?</p>
                    <input type="radio" name="q24" value="a"> A. skip<br>
                    <input type="radio" name="q24" value="b"> B. next<br>
                    <input type="radio" name="q24" value="c"> C. continue<br>
                    <input type="radio" name="q24" value="d"> D. pass<br><br>

                    <p>25. What does range(1, 10, 2) produce?</p>
                    <input type="radio" name="q25" value="a"> A. 1, 2, 3, 4, 5, 6, 7, 8, 9<br>
                    <input type="radio" name="q25" value="b"> B. 2, 4, 6, 8, 10<br>
                    <input type="radio" name="q25" value="c"> C. 1, 3, 5, 7, 9<br>
                    <input type="radio" name="q25" value="d"> D. 1, 3, 5, 7, 9, 11<br><br>

                    <p>26. What does the logical operator "and" require?</p>
                    <input type="radio" name="q26" value="a"> A. At least one True<br>
                    <input type="radio" name="q26" value="b"> B. Both conditions True<br>
                    <input type="radio" name="q26" value="c"> C. Neither True<br>
                    <input type="radio" name="q26" value="d"> D. One condition False<br><br>

                    <p>27. Correct ternary expression in Python?</p>
                    <input type="radio" name="q27" value="a"> A. age >= 18 ? "Adult" : "Minor"<br>
                    <input type="radio" name="q27" value="b"> B. "Adult" if age >= 18 else "Minor"<br>
                    <input type="radio" name="q27" value="c"> C. if age >= 18 then "Adult" else "Minor"<br>
                    <input type="radio" name="q27" value="d"> D. (age >= 18) && "Adult" || "Minor"<br><br>

                    <p>28. How do you print without a new line?</p>
                    <input type="radio" name="q28" value="a"> A. print(value, end="\n")<br>
                    <input type="radio" name="q28" value="b"> B. println(value)<br>
                    <input type="radio" name="q28" value="c"> C. print(value, end="")<br>
                    <input type="radio" name="q28" value="d"> D. print_no_nl(value)<br><br>

                    <p>29. Which Python version introduced the match statement?</p>
                    <input type="radio" name="q29" value="a"> A. Python 3.6<br>
                    <input type="radio" name="q29" value="b"> B. Python 3.8<br>
                    <input type="radio" name="q29" value="c"> C. Python 3.10<br>
                    <input type="radio" name="q29" value="d"> D. Python 3.12<br><br>

                    <p>30. What does the "not" operator do?</p>
                    <input type="radio" name="q30" value="a"> A. Compares two values<br>
                    <input type="radio" name="q30" value="b"> B. Adds two values<br>
                    <input type="radio" name="q30" value="c"> C. Reverses a boolean condition<br>
                    <input type="radio" name="q30" value="d"> D. Returns None<br><br>

                    <h3>— Functions &amp; Collections (Q31–40) —</h3>

                    <p>31. Which keyword defines a function in Python?</p>
                    <input type="radio" name="q31" value="a"> A. function<br>
                    <input type="radio" name="q31" value="b"> B. func<br>
                    <input type="radio" name="q31" value="c"> C. def<br>
                    <input type="radio" name="q31" value="d"> D. fn<br><br>

                    <p>32. Which collection type is immutable?</p>
                    <input type="radio" name="q32" value="a"> A. list<br>
                    <input type="radio" name="q32" value="b"> B. dict<br>
                    <input type="radio" name="q32" value="c"> C. tuple<br>
                    <input type="radio" name="q32" value="d"> D. set<br><br>

                    <p>33. Which method adds an item to the end of a list?</p>
                    <input type="radio" name="q33" value="a"> A. list.add()<br>
                    <input type="radio" name="q33" value="b"> B. list.push()<br>
                    <input type="radio" name="q33" value="c"> C. list.append()<br>
                    <input type="radio" name="q33" value="d"> D. list.insert()<br><br>

                    <p>34. What does *args allow in a function?</p>
                    <input type="radio" name="q34" value="a"> A. Keyword arguments<br>
                    <input type="radio" name="q34" value="b"> B. Any number of positional arguments<br>
                    <input type="radio" name="q34" value="c"> C. Two arguments only<br>
                    <input type="radio" name="q34" value="d"> D. No arguments<br><br>

                    <p>35. What does [x**2 for x in range(1, 4)] produce?</p>
                    <input type="radio" name="q35" value="a"> A. [1, 2, 3]<br>
                    <input type="radio" name="q35" value="b"> B. [2, 4, 6]<br>
                    <input type="radio" name="q35" value="c"> C. [1, 4, 9]<br>
                    <input type="radio" name="q35" value="d"> D. [1, 8, 27]<br><br>

                    <p>36. Which collection stores key-value pairs?</p>
                    <input type="radio" name="q36" value="a"> A. list<br>
                    <input type="radio" name="q36" value="b"> B. tuple<br>
                    <input type="radio" name="q36" value="c"> C. set<br>
                    <input type="radio" name="q36" value="d"> D. dict<br><br>

                    <p>37. Sets in Python do NOT allow?</p>
                    <input type="radio" name="q37" value="a"> A. Mixed types<br>
                    <input type="radio" name="q37" value="b"> B. Integers<br>
                    <input type="radio" name="q37" value="c"> C. Duplicate values<br>
                    <input type="radio" name="q37" value="d"> D. Strings<br><br>

                    <p>38. What does dict.get("key", "default") return when key is missing?</p>
                    <input type="radio" name="q38" value="a"> A. None<br>
                    <input type="radio" name="q38" value="b"> B. Error<br>
                    <input type="radio" name="q38" value="c"> C. "default"<br>
                    <input type="radio" name="q38" value="d"> D. 0<br><br>

                    <p>39. What does **kwargs allow in a function?</p>
                    <input type="radio" name="q39" value="a"> A. Positional arguments<br>
                    <input type="radio" name="q39" value="b"> B. Any number of keyword arguments<br>
                    <input type="radio" name="q39" value="c"> C. Default arguments only<br>
                    <input type="radio" name="q39" value="d"> D. No arguments<br><br>

                    <p>40. Which set operation returns elements in both sets?</p>
                    <input type="radio" name="q40" value="a"> A. a | b<br>
                    <input type="radio" name="q40" value="b"> B. a - b<br>
                    <input type="radio" name="q40" value="c"> C. a &amp; b<br>
                    <input type="radio" name="q40" value="d"> D. a ^ b<br><br>

                    <h3>— Object-Oriented Programming (Q41–50) —</h3>

                    <p>41. What keyword defines a class in Python?</p>
                    <input type="radio" name="q41" value="a"> A. object<br>
                    <input type="radio" name="q41" value="b"> B. class<br>
                    <input type="radio" name="q41" value="c"> C. struct<br>
                    <input type="radio" name="q41" value="d"> D. type<br><br>

                    <p>42. What is the Python class constructor method called?</p>
                    <input type="radio" name="q42" value="a"> A. __constructor__<br>
                    <input type="radio" name="q42" value="b"> B. __new__<br>
                    <input type="radio" name="q42" value="c"> C. __init__<br>
                    <input type="radio" name="q42" value="d"> D. __create__<br><br>

                    <p>43. What does "self" refer to in a Python method?</p>
                    <input type="radio" name="q43" value="a"> A. The parent class<br>
                    <input type="radio" name="q43" value="b"> B. The current object instance<br>
                    <input type="radio" name="q43" value="c"> C. A static member<br>
                    <input type="radio" name="q43" value="d"> D. The class itself<br><br>

                    <p>44. What convention marks a "private" attribute in Python?</p>
                    <input type="radio" name="q44" value="a"> A. Single underscore prefix: _name<br>
                    <input type="radio" name="q44" value="b"> B. Double underscore prefix: __name<br>
                    <input type="radio" name="q44" value="c"> C. private keyword<br>
                    <input type="radio" name="q44" value="d"> D. ALL_CAPS naming<br><br>

                    <p>45. Inheritance syntax in Python?</p>
                    <input type="radio" name="q45" value="a"> A. class Dog extends Animal:<br>
                    <input type="radio" name="q45" value="b"> B. class Dog implements Animal:<br>
                    <input type="radio" name="q45" value="c"> C. class Dog(Animal):<br>
                    <input type="radio" name="q45" value="d"> D. class Dog : Animal:<br><br>

                    <p>46. Which function calls the parent constructor in Python?</p>
                    <input type="radio" name="q46" value="a"> A. parent().__init__()<br>
                    <input type="radio" name="q46" value="b"> B. super().__init__()<br>
                    <input type="radio" name="q46" value="c"> C. base().__init__()<br>
                    <input type="radio" name="q46" value="d"> D. this.__init__()<br><br>

                    <p>47. What modules are needed for abstract classes in Python?</p>
                    <input type="radio" name="q47" value="a"> A. import abstract<br>
                    <input type="radio" name="q47" value="b"> B. from abstract import ABC<br>
                    <input type="radio" name="q47" value="c"> C. from abc import ABC, abstractmethod<br>
                    <input type="radio" name="q47" value="d"> D. import abc.class<br><br>

                    <p>48. What is the __str__ dunder method used for?</p>
                    <input type="radio" name="q48" value="a"> A. Converting a string to an object<br>
                    <input type="radio" name="q48" value="b"> B. Defining the string representation of an object<br>
                    <input type="radio" name="q48" value="c"> C. Counting string length<br>
                    <input type="radio" name="q48" value="d"> D. Comparing two strings<br><br>

                    <p>49. Correct multiple inheritance syntax in Python?</p>
                    <input type="radio" name="q49" value="a"> A. class Duck extends Flyable, Swimmable:<br>
                    <input type="radio" name="q49" value="b"> B. class Duck(Flyable, Swimmable):<br>
                    <input type="radio" name="q49" value="c"> C. class Duck implements Flyable and Swimmable:<br>
                    <input type="radio" name="q49" value="d"> D. class Duck: Flyable, Swimmable<br><br>

                    <p>50. Which decorator creates a getter using Python's property system?</p>
                    <input type="radio" name="q50" value="a"> A. @getter<br>
                    <input type="radio" name="q50" value="b"> B. @staticmethod<br>
                    <input type="radio" name="q50" value="c"> C. @property<br>
                    <input type="radio" name="q50" value="d"> D. @classmethod<br><br>

                    <button type="submit">Submit Final Exam</button>
                </form>

            @endif {{-- end quiz sections --}}

        </div>
    </div>

</body>
</html>
