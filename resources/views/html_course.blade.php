<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Development Course</title>
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
            <div class="result-box"
                style="
        padding:20px;
        margin-bottom:20px;
        border-radius:10px;
        background: {{ session('passed') ? '#d4edda' : '#f8d7da' }};
        color: {{ session('passed') ? '#155724' : '#721c24' }};
    ">

                <h2>
                    {{ session('passed') ? '🎉 Congratulations, You Passed!' : '❌ You Failed!' }}
                </h2>

                <p>Score: {{ session('score') }}/{{ session('total', 10) }}</p>
                <p>Percentage: {{ session('percentage') }}%</p>

                @if (session('passed'))
                    @php
                        $nextRoute = match(session('quiz')) {
                            'lesson1' => route('html.course') . '#lesson2',
                            'lesson2' => route('html.course') . '#lesson3',
                            'lesson3' => route('html.course') . '#lesson4',
                            'lesson4' => route('html.course') . '#lesson5',
                            'lesson5' => route('html.course') . '#final',
                            'final'   => route('dashboard'),
                            default   => route('html.course'),
                        };
                        $nextLabel = session('quiz') === 'final' ? 'Back to Dashboard' : 'Proceed to Next Lesson →';
                    @endphp
                    <a href="{{ $nextRoute }}">
                        <button type="button">{{ $nextLabel }}</button>
                    </a>
                @else
                    @php
                        $retakeRoute = match(session('quiz')) {
                            'lesson1' => route('html.quiz'),
                            'lesson2' => route('lesson2.quiz'),
                            'lesson3' => route('lesson3.quiz'),
                            'lesson4' => route('lesson4.quiz'),
                            'lesson5' => route('lesson5.quiz'),
                            'final'   => route('final.exam'),
                            default   => route('html.quiz'),
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
                    <button type="button">View HTML Certificate</button>
                </a>
            </div>
        @endif

        <div class="lesson-box">

            {{-- ============================================================ --}}
            {{-- LESSON CONTENT (no quiz active)                              --}}
            {{-- ============================================================ --}}
            @if (!$showQuiz)

                {{-- Lesson 1 --}}
                <h2>Lesson 1: Introduction to Web Development and HTML Basics</h2>

                <p><b>HTML - </b> stands for HyperText Markup Language. It provides the structure and content of the
                    webpage (e.g., headings, paragraphs, images, forms) <br>
                    <b>CSS - </b> stands for Cascading Style Sheets. It handles the design, layout, and visual styling
                    of the webpage (e.g., colors, fonts spacing). <br>
                    <b>JavaScript - </b> Adds interactivity and dynamic behavior to the webpage (e.g., animations, form
                    validation, fetching data dynamically).
                </p>

                <h3>Basic Structure:</h3>
                <pre>
&lt;html&gt;
&lt;head&gt;
&lt;title&gt;My Page&lt;/title&gt;
&lt;link rel="stylesheet" href="style.css"&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;h1&gt; Hello World!&lt;/h1&gt;
&lt;/body&gt;
&lt;/html&gt;
</pre>

                <h3>Explanation of Each Line:</h3>
                <pre>
&lt;html&gt;
This is the root element of an HTML document.
All content of the webpage must be placed inside this tag.

&lt;head&gt;
This section contains metadata or information about the webpage.
Content inside this section is not displayed directly on the page.

&lt;title&gt;My Page&lt;/title&gt;
This defines the title of the webpage.
It appears on the browser tab.

&lt;link rel="stylesheet" href="style.css"&gt;
This links an external CSS file to the HTML document.
The "rel" attribute specifies the relationship as a stylesheet.
The "href" attribute specifies the location of the CSS file.

&lt;/head&gt;
This closes the head section.

&lt;body&gt;
This section contains all the visible content of the webpage.

&lt;h1&gt;Hello World!&lt;/h1&gt;
This is a heading element.
The &lt;h1&gt; tag represents the largest heading.

&lt;/body&gt;
This closes the body section.

&lt;/html&gt;
This closes the HTML document.
</pre>

                <h3>Important Notes:</h3>
                <ul>
                    <li>HTML is used to define the structure of a webpage.</li>
                    <li>CSS is used to style and design the webpage.</li>
                    <li>JavaScript is used to add functionality and interactivity.</li>
                    <li>Most HTML elements have both opening and closing tags.</li>
                    <li>Example: &lt;h1&gt; ... &lt;/h1&gt;</li>
                </ul>

                <h2>Lesson 1.1: Types of HTML Elements</h2>
                <p>HTML elements define the structure and content of a webpage. Each element consists of an opening tag,
                    content, and a closing tag. Common types of elements include headings, paragraphs, images, links,
                    and comments.</p>

                <h3>1. Headings</h3>
                <p>Headings are used to create titles and subtitles. HTML provides six levels of headings:
                    <code>&lt;h1&gt;</code> to <code>&lt;h6&gt;</code>. <code>&lt;h1&gt;</code> represents the most
                    important heading, and <code>&lt;h6&gt;</code> the least.</p>
                <pre>
&lt;h1&gt;Main Title&lt;/h1&gt;
&lt;h2&gt;Sub Title&lt;/h2&gt;
&lt;h3&gt;Section Heading&lt;/h3&gt;
</pre>

                <h3>2. Paragraphs</h3>
                <p>Paragraphs are defined with the <code>&lt;p&gt;</code> tag. They group sentences together and
                    automatically add spacing above and below the text.</p>
                <pre>
&lt;p&gt;This is a paragraph of text. It can contain multiple sentences.&lt;/p&gt;
&lt;p&gt;Another paragraph for clarity.&lt;/p&gt;
</pre>

                <h3>3. Images</h3>
                <p>Images are displayed using the <code>&lt;img&gt;</code> tag. This tag is self-closing and requires
                    the <code>src</code> attribute to specify the image file and the <code>alt</code> attribute for
                    alternative text.</p>
                <pre>
&lt;img src="logo.png" alt="Website Logo"&gt;
&lt;img src="photo.jpg" alt="A beautiful scenery"&gt;
</pre>

                <h3>4. Links</h3>
                <p>Links are created using the <code>&lt;a&gt;</code> tag. The <code>href</code> attribute specifies the
                    URL. Clicking the link navigates the user to the destination.</p>
                <pre>
&lt;a href="https://www.example.com"&gt;Visit Example&lt;/a&gt;
&lt;a href="page2.html"&gt;Go to Page 2&lt;/a&gt;
</pre>

                <h3>5. Comments</h3>
                <p>Comments are used to leave notes inside HTML code. They are not displayed in the browser.</p>
                <pre>
&lt;!-- This is a comment. It will not appear on the webpage. --&gt;
&lt;!-- Remember to update the image paths --&gt;
</pre>

                <form method="GET" action="{{ route('html.quiz') }}">
                    <button>Quiz Lesson 1</button>
                </form>

                {{-- Lesson 2 locked/unlocked --}}
                @if ($current_lesson < 2)
                    <hr>
                    <h2>Lesson 2 🔒</h2>
                    <p style="color: gray;">Complete Lesson 1 Quiz to unlock this lesson.</p>
                @endif

                @if ($current_lesson >= 2)
                    <hr>
                    <h2 id="lesson2">Lesson 2: HTML Forms</h2>
                    <p>HTML Forms are used to collect user input, such as text, passwords, choices, or files. Forms send
                        the collected data to a server for processing.</p>

                    <h3>Basic Structure:</h3>
                    <pre>
&lt;form action="submit.php" method="POST"&gt;

    &lt;!-- Text Input --&gt;
    &lt;label for="username"&gt;Username:&lt;/label&gt;
    &lt;input type="text" id="username" name="username" placeholder="Enter your username"&gt;

    &lt;br&gt;&lt;br&gt;

    &lt;!-- Password Input --&gt;
    &lt;label for="password"&gt;Password:&lt;/label&gt;
    &lt;input type="password" id="password" name="password" placeholder="Enter your password"&gt;

    &lt;br&gt;&lt;br&gt;

    &lt;!-- Checkbox --&gt;
    &lt;input type="checkbox" id="remember" name="remember"&gt;
    &lt;label for="remember"&gt;Remember me&lt;/label&gt;

    &lt;br&gt;&lt;br&gt;

    &lt;!-- Radio Buttons --&gt;
    &lt;label&gt;Gender:&lt;/label&gt;
    &lt;input type="radio" id="male" name="gender" value="male"&gt;
    &lt;label for="male"&gt;Male&lt;/label&gt;
    &lt;input type="radio" id="female" name="gender" value="female"&gt;
    &lt;label for="female"&gt;Female&lt;/label&gt;

    &lt;br&gt;&lt;br&gt;

    &lt;!-- Submit Button --&gt;
    &lt;button type="submit"&gt;Submit&lt;/button&gt;

&lt;/form&gt;
</pre>

                    <h3>Explanation of Each Line:</h3>
                    <pre>
&lt;form action="submit.php" method="POST"&gt;
Starts the form.
"action" specifies where the form data is sent.
"method=POST" sends the data securely.

&lt;label for="username"&gt;Username:&lt;/label&gt;
Label for the username input.

&lt;input type="text" id="username" name="username" placeholder="Enter your username"&gt;
Single-line text input.

&lt;input type="password" id="password" name="password" placeholder="Enter your password"&gt;
Password input hides typed characters.

&lt;input type="checkbox" id="remember" name="remember"&gt;
Checkbox for options that can be selected or not.

&lt;input type="radio" id="male" name="gender" value="male"&gt;
&lt;input type="radio" id="female" name="gender" value="female"&gt;
Radio buttons allow only one choice per group.

&lt;button type="submit"&gt;Submit&lt;/button&gt;
Sends the form data to the server.
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>Every input should have a "name" attribute to send data correctly to the server.</li>
                        <li>Labels improve accessibility and usability.</li>
                        <li>Use POST for sensitive information like passwords.</li>
                        <li>Forms can include many input types: text, password, checkbox, radio, file, email, number, etc.</li>
                        <li>Always test forms to ensure data is sent correctly.</li>
                    </ul>

                    <h2>Lesson 2.1: More HTML Form Elements</h2>
                    <p>HTML forms can also include dropdown menus, multi-line text areas, and file uploads to collect
                        more specific types of input from users.</p>

                    <h3>Basic Structure:</h3>
                    <pre>
&lt;form action="submit.php" method="POST" enctype="multipart/form-data"&gt;

    &lt;!-- Dropdown Menu --&gt;
    &lt;label for="country"&gt;Select Country:&lt;/label&gt;
    &lt;select id="country" name="country"&gt;
        &lt;option value="philippines"&gt;Philippines&lt;/option&gt;
        &lt;option value="japan"&gt;Japan&lt;/option&gt;
        &lt;option value="usa"&gt;USA&lt;/option&gt;
    &lt;/select&gt;

    &lt;br&gt;&lt;br&gt;

    &lt;!-- Multi-line Text Area --&gt;
    &lt;label for="bio"&gt;Short Bio:&lt;/label&gt;
    &lt;textarea id="bio" name="bio" rows="4" cols="50" placeholder="Write something about yourself"&gt;&lt;/textarea&gt;

    &lt;br&gt;&lt;br&gt;

    &lt;!-- File Upload --&gt;
    &lt;label for="profilePic"&gt;Upload Profile Picture:&lt;/label&gt;
    &lt;input type="file" id="profilePic" name="profilePic"&gt;

    &lt;br&gt;&lt;br&gt;

    &lt;!-- Submit Button --&gt;
    &lt;button type="submit"&gt;Submit&lt;/button&gt;

&lt;/form&gt;
</pre>

                    <h3>Explanation of Each Line:</h3>
                    <pre>
&lt;form action="submit.php" method="POST" enctype="multipart/form-data"&gt;
Starts the form.
"action" specifies where the form data is sent.
"method=POST" sends the data securely.
"enctype" is required for file uploads.

&lt;label for="country"&gt;Select Country:&lt;/label&gt;
Label for the dropdown menu.

&lt;select id="country" name="country"&gt;...&lt;/select&gt;
Creates a dropdown menu.
Each &lt;option&gt; is a choice the user can select.

&lt;label for="bio"&gt;Short Bio:&lt;/label&gt;
Label for the multi-line text area.

&lt;textarea id="bio" name="bio" rows="4" cols="50" placeholder="Write something about yourself"&gt;&lt;/textarea&gt;
Creates a multi-line input box.
"rows" sets number of lines, "cols" sets width.
"placeholder" shows a hint inside the box.

&lt;label for="profilePic"&gt;Upload Profile Picture:&lt;/label&gt;
Label for the file input.

&lt;input type="file" id="profilePic" name="profilePic"&gt;
Lets user upload a file.

&lt;button type="submit"&gt;Submit&lt;/button&gt;
Sends all form data to the server.
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>&lt;select&gt; menus let users choose from predefined options.</li>
                        <li>&lt;textarea&gt; allows multiple lines of text.</li>
                        <li>&lt;input type="file"&gt; requires <code>enctype="multipart/form-data"</code>.</li>
                        <li>Always use &lt;label&gt; tags for better accessibility.</li>
                        <li>Test all form elements to make sure data is correctly submitted.</li>
                    </ul>

                    <form method="GET" action="{{ route('lesson2.quiz') }}">
                        <button>Quiz Lesson 2</button>
                    </form>
                @endif

                {{-- Lesson 3 locked/unlocked --}}
                @if ($current_lesson < 3)
                    <hr>
                    <h2>Lesson 3 🔒</h2>
                    <p style="color: gray;">Complete Lesson 2 Quiz to unlock this lesson.</p>
                @endif

                @if ($current_lesson >= 3)
                    <hr>
                    <h2 id="lesson3">Lesson 3: Introduction to CSS</h2>
                    <p><b>CSS (Cascading Style Sheets)</b> is used to design and style a webpage. It controls colors, fonts, spacing, layout, and overall appearance.</p>

                    <h3>Why Use CSS?</h3>
                    <ul>
                        <li>Makes websites visually appealing</li>
                        <li>Separates design from structure (HTML)</li>
                        <li>Improves user experience</li>
                        <li>Allows reuse of styles across pages</li>
                    </ul>

                    <h3>Basic CSS Syntax:</h3>
                    <pre>
selector {
    property: value;
}
</pre>

                    <h3>Example:</h3>
                    <pre>
h1 {
    color: blue;
    font-size: 24px;
}
</pre>

                    <h3>Explanation:</h3>
                    <pre>
h1 → selector (target element)
color → property (what to change)
blue → value (the style applied)

font-size → changes text size
24px → value in pixels
</pre>

                    <h2>Lesson 3.1: Types of CSS</h2>

                    <h3>1. Inline CSS</h3>
                    <p>Applied directly inside an HTML tag.</p>
                    <pre>
&lt;h1 style="color:red;"&gt;Hello&lt;/h1&gt;
</pre>

                    <h3>2. Internal CSS</h3>
                    <p>Defined inside the &lt;style&gt; tag in the &lt;head&gt; section.</p>
                    <pre>
&lt;head&gt;
&lt;style&gt;
h1 {
    color: green;
}
&lt;/style&gt;
&lt;/head&gt;
</pre>

                    <h3>3. External CSS</h3>
                    <p>Stored in a separate .css file and linked to HTML.</p>
                    <pre>
&lt;link rel="stylesheet" href="style.css"&gt;
</pre>

                    <p><b>style.css</b></p>
                    <pre>
h1 {
    color: purple;
}
</pre>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>External CSS is the best practice</li>
                        <li>Inline CSS is not recommended for large projects</li>
                        <li>Internal CSS is useful for small pages</li>
                    </ul>

                    <h2>Lesson 3.2: CSS Units (px, em, %)</h2>

                    <h3>1. px (Pixels)</h3>
                    <p>Fixed size unit. Does not change based on screen size.</p>
                    <pre>
p {
    font-size: 16px;
}
</pre>

                    <h3>2. em</h3>
                    <p>Relative to the parent element's font size.</p>
                    <pre>
div {
    font-size: 20px;
}

p {
    font-size: 1.5em;
}
</pre>

                    <h3>3. % (Percentage)</h3>
                    <p>Relative to the parent element.</p>
                    <pre>
div {
    width: 50%;
}
</pre>

                    <h3>Comparison:</h3>
                    <ul>
                        <li><b>px</b> → fixed</li>
                        <li><b>em</b> → flexible</li>
                        <li><b>%</b> → responsive</li>
                    </ul>

                    <h2>Lesson 3.3: Basic Styling Properties</h2>
                    <pre>
body {
    background-color: lightgray;
}

h1 {
    color: blue;
    text-align: center;
}

p {
    font-size: 18px;
    color: black;
}
</pre>

                    <h3>Common Properties:</h3>
                    <ul>
                        <li>color → text color</li>
                        <li>background-color → background</li>
                        <li>font-size → text size</li>
                        <li>text-align → alignment</li>
                        <li>margin → space outside</li>
                        <li>padding → space inside</li>
                    </ul>

                    <h3>Important Notes:</h3>
                    <ul>
                        <li>CSS works with selectors (tags, classes, ids)</li>
                        <li>You can combine multiple styles in one rule</li>
                        <li>Always use external CSS for cleaner code</li>
                        <li>Practice using different units for responsive design</li>
                    </ul>

                    <form method="GET" action="{{ route('lesson3.quiz') }}">
                        <button>Quiz Lesson 3</button>
                    </form>
                @endif

                {{-- Lesson 4 locked/unlocked --}}
                @if ($current_lesson < 4)
                    <hr>
                    <h2>Lesson 4 🔒</h2>
                    <p style="color: gray;">Complete Lesson 3 Quiz to unlock this lesson.</p>
                @endif

                @if ($current_lesson >= 4)
                    <hr>
                    <h2 id="lesson4">Lesson 4: CSS Colors, Background, and Opacity</h2>
                    <p>CSS is used to style HTML elements. In this lesson, you will learn how to change text color, background color, and control transparency using opacity.</p>

                    <hr>
                    <h2>1. Text Color</h2>
                    <p>The <code>color</code> property changes the color of text.</p>
                    <pre>
h1 {
    color: red;
}
</pre>
                    <p><b>Explanation:</b> This will make all &lt;h1&gt; text red.</p>

                    <hr>
                    <h2>2. Background Color</h2>
                    <p>The <code>background-color</code> property changes the background of an element.</p>
                    <pre>
body {
    background-color: lightblue;
}
</pre>
                    <p><b>Explanation:</b> The entire webpage background becomes light blue.</p>

                    <hr>
                    <h2>3. Opacity</h2>
                    <p>The <code>opacity</code> property controls transparency. Value ranges from 0 to 1.</p>
                    <pre>
div {
    opacity: 0.5;
}
</pre>
                    <p><b>Explanation:</b> The element becomes 50% visible.</p>

                    <hr>
                    <h2>4. Combined Example</h2>
                    <pre>
h1 {
    color: white;
    background-color: black;
    opacity: 0.8;
    text-align: center;
}
</pre>

                    <hr>
                    <h2>5. How CSS is Applied in a Webpage (Execution Flow)</h2>
                    <pre>
1. Browser reads HTML structure
2. Browser loads CSS styles
3. CSS is applied to matching HTML elements
4. Final styled webpage is displayed
</pre>

                    <hr>
                    <h2>6. Full Working Example (HTML + CSS Together)</h2>
                    <pre>
&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;CSS Lesson Example&lt;/title&gt;
    &lt;style&gt;
        body {
            background-color: lightgray;
        }
        h1 {
            color: blue;
            text-align: center;
            opacity: 0.9;
        }
        p {
            color: black;
            font-size: 18px;
        }
    &lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Hello World&lt;/h1&gt;
    &lt;p&gt;This is a styled webpage using CSS.&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;
</pre>

                    <hr>
                    <h2>Important Notes</h2>
                    <ul>
                        <li><b>color</b> → changes text color</li>
                        <li><b>background-color</b> → changes background</li>
                        <li><b>opacity</b> → controls transparency (0 = invisible, 1 = visible)</li>
                        <li>CSS styles are applied after HTML is loaded</li>
                    </ul>

                    <hr>
                    <form method="GET" action="{{ route('lesson4.quiz') }}">
                        <button>Quiz Lesson 4</button>
                    </form>
                @endif

                {{-- Lesson 5 locked/unlocked --}}
                @if ($current_lesson < 5)
                    <hr>
                    <h2>Lesson 5 🔒</h2>
                    <p style="color: gray;">Complete Lesson 4 Quiz to unlock this lesson.</p>
                @endif

                @if ($current_lesson >= 5)
                    <hr>
                    <h2 id="lesson5">Lesson 5: Introduction to JavaScript</h2>
                    <p><b>JavaScript</b> is a programming language used to make webpages interactive and dynamic.</p>

                    <h3>What Can JavaScript Do?</h3>
                    <ul>
                        <li>Change HTML content</li>
                        <li>Modify CSS styles</li>
                        <li>Handle user interactions (clicks, typing)</li>
                        <li>Create animations</li>
                    </ul>

                    <h3>Adding JavaScript in HTML</h3>
                    <pre>
&lt;script&gt;
    alert("Hello World!");
&lt;/script&gt;
</pre>
                    <p>Or external file:</p>
                    <pre>
&lt;script src="script.js"&gt;&lt;/script&gt;
</pre>

                    <hr>
                    <h2>Lesson 5.1: JavaScript Elements</h2>
                    <h3>Selecting Elements</h3>
                    <pre>
document.getElementById("demo");
document.querySelector(".className");
</pre>

                    <h3>Example:</h3>
                    <pre>
&lt;p id="demo"&gt;Hello&lt;/p&gt;

&lt;script&gt;
document.getElementById("demo").innerHTML = "Hello World!";
&lt;/script&gt;
</pre>

                    <hr>
                    <h2>Lesson 5.2: Changing CSS using JavaScript</h2>
                    <pre>
document.getElementById("demo").style.color = "red";
</pre>
                    <p>JavaScript can directly modify CSS styles dynamically.</p>

                    <hr>
                    <h2>Lesson 5.3: Events and Event Handlers</h2>
                    <h3>Common Events:</h3>
                    <ul>
                        <li>onclick</li>
                        <li>onmouseover</li>
                        <li>onchange</li>
                        <li>onkeyup</li>
                    </ul>

                    <h3>Example:</h3>
                    <pre>
&lt;button onclick="changeText()"&gt;Click Me&lt;/button&gt;

&lt;script&gt;
function changeText() {
    document.getElementById("demo").innerHTML = "Clicked!";
}
&lt;/script&gt;
</pre>

                    <hr>
                    <h2>Lesson 5.4: Event Listeners</h2>
                    <pre>
document.getElementById("btn").addEventListener("click", function() {
    alert("Button clicked!");
});
</pre>

                    <h3>Difference:</h3>
                    <ul>
                        <li>Event Handler → inside HTML</li>
                        <li>Event Listener → inside JavaScript (recommended)</li>
                    </ul>

                    <hr>
                    <h3>Important Notes:</h3>
                    <ul>
                        <li>JavaScript makes websites interactive</li>
                        <li>Use event listeners for better practice</li>
                        <li>JS can control both HTML and CSS</li>
                        <li>Always place script at bottom or use external file</li>
                    </ul>

                    <form method="GET" action="{{ route('lesson5.quiz') }}">
                        <button>Quiz Lesson 5</button>
                    </form>
                @endif

                {{-- Final Exam locked/unlocked --}}
                @if ($current_lesson < 6)
                    <hr>
                    <h2 id="final">Final Exam 🔒</h2>
                    <p style="color: gray;">Complete Lesson 5 Quiz to unlock the Final Exam.</p>
                @endif

                @if ($current_lesson >= 6)
                    <hr>
                    <h2 id="final">🎓 Final Exam</h2>
                    <form method="GET" action="{{ route('final.exam') }}">
                        <button>Take Final Exam</button>
                    </form>
                @endif

            @endif {{-- end !$showQuiz --}}


            {{-- ============================================================ --}}
            {{-- QUIZ SECTIONS                                                --}}
            {{-- ============================================================ --}}

            @if ($showQuiz === true)
                {{-- ---- Lesson 1 Quiz ---- --}}
                <h2>Lesson 1 Quiz</h2>
                <form method="POST" action="{{ route('html.submit') }}">
                    @csrf

                    <p>1. What does HTML stand for?</p>
                    <input type="radio" name="q1" value="a"> HyperText Markup Language <br>
                    <input type="radio" name="q1" value="b"> Home Tool Markup Language <br>
                    <input type="radio" name="q1" value="c"> Hyperlinks and Text Markup Language <br>
                    <input type="radio" name="q1" value="d"> HyperText Makeup Language <br>

                    <p>2. Which tag is used for paragraphs?</p>
                    <input type="radio" name="q2" value="a"> &lt;p&gt; <br>
                    <input type="radio" name="q2" value="b"> &lt;h1&gt; <br>
                    <input type="radio" name="q2" value="c"> &lt;div&gt; <br>
                    <input type="radio" name="q2" value="d"> &lt;span&gt; <br>

                    <p>3. Which of the following is NOT a primary purpose of HTML?</p>
                    <input type="radio" name="q3" value="a"> Structuring content <br>
                    <input type="radio" name="q3" value="b"> Creating headings and paragraphs <br>
                    <input type="radio" name="q3" value="c"> Styling with colors and fonts <br>
                    <input type="radio" name="q3" value="d"> Adding images and links <br>

                    <p>4. Which tag is used to display an image?</p>
                    <input type="radio" name="q4" value="a"> &lt;img&gt; <br>
                    <input type="radio" name="q4" value="b"> &lt;image&gt; <br>
                    <input type="radio" name="q4" value="c"> &lt;picture&gt; <br>
                    <input type="radio" name="q4" value="d"> &lt;figure&gt; <br>

                    <p>5. What attribute is required in an &lt;img&gt; tag?</p>
                    <input type="radio" name="q5" value="a"> src <br>
                    <input type="radio" name="q5" value="b"> href <br>
                    <input type="radio" name="q5" value="c"> alt <br>
                    <input type="radio" name="q5" value="d"> Both src and alt <br>

                    <p>6. Which tag is used to create a link?</p>
                    <input type="radio" name="q6" value="a"> &lt;a&gt; <br>
                    <input type="radio" name="q6" value="b"> &lt;link&gt; <br>
                    <input type="radio" name="q6" value="c"> &lt;href&gt; <br>
                    <input type="radio" name="q6" value="d"> &lt;nav&gt; <br>

                    <p>7. Which tag defines the largest heading?</p>
                    <input type="radio" name="q7" value="a"> &lt;h1&gt; <br>
                    <input type="radio" name="q7" value="b"> &lt;h3&gt; <br>
                    <input type="radio" name="q7" value="c"> &lt;h6&gt; <br>
                    <input type="radio" name="q7" value="d"> &lt;header&gt; <br>

                    <p>8. Comments in HTML are written as:</p>
                    <input type="radio" name="q8" value="a"> &lt;!-- Comment --&gt; <br>
                    <input type="radio" name="q8" value="b"> &lt;# Comment #&gt; <br>
                    <input type="radio" name="q8" value="c"> &lt;* Comment *&gt; <br>
                    <input type="radio" name="q8" value="d"> &lt;!--- Comment ---&gt; <br>

                    <p>9. Where does the content of a webpage go?</p>
                    <input type="radio" name="q9" value="a"> Inside the &lt;head&gt; tag <br>
                    <input type="radio" name="q9" value="b"> Inside the &lt;body&gt; tag <br>
                    <input type="radio" name="q9" value="c"> Inside the &lt;title&gt; tag <br>
                    <input type="radio" name="q9" value="d"> Outside the &lt;html&gt; tag <br>

                    <p>10. Which of the following correctly links an external CSS file?</p>
                    <input type="radio" name="q10" value="a"> &lt;link rel="stylesheet" href="style.css"&gt; <br>
                    <input type="radio" name="q10" value="b"> &lt;style src="style.css"&gt; <br>
                    <input type="radio" name="q10" value="c"> &lt;script src="style.css"&gt; <br>
                    <input type="radio" name="q10" value="d"> &lt;css href="style.css"&gt; <br>
                    <br>
                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson2')
                {{-- ---- Lesson 2 Quiz ---- --}}
                <h2>Lesson 2 Quiz</h2>
                <form method="POST" action="{{ route('lesson2.submit') }}">
                    @csrf

                    <p>1. Which attribute of the &lt;form&gt; tag specifies where the data is sent?</p>
                    <input type="radio" name="q1" value="a"> method <br>
                    <input type="radio" name="q1" value="b"> action <br>
                    <input type="radio" name="q1" value="c"> name <br>
                    <input type="radio" name="q1" value="d"> id <br>

                    <p>2. Which &lt;input&gt; type hides the characters typed by the user?</p>
                    <input type="radio" name="q2" value="a"> text <br>
                    <input type="radio" name="q2" value="b"> password <br>
                    <input type="radio" name="q2" value="c"> checkbox <br>
                    <input type="radio" name="q2" value="d"> radio <br>

                    <p>3. Which attribute is required when using &lt;input type="file"&gt;?</p>
                    <input type="radio" name="q3" value="a"> method="POST" <br>
                    <input type="radio" name="q3" value="b"> enctype="multipart/form-data" <br>
                    <input type="radio" name="q3" value="c"> placeholder <br>
                    <input type="radio" name="q3" value="d"> action <br>

                    <p>4. Which element is used to create a multi-line text input?</p>
                    <input type="radio" name="q4" value="a"> &lt;input type="text"&gt; <br>
                    <input type="radio" name="q4" value="b"> &lt;textarea&gt; <br>
                    <input type="radio" name="q4" value="c"> &lt;select&gt; <br>
                    <input type="radio" name="q4" value="d"> &lt;button&gt; <br>

                    <p>5. How do you group radio buttons so that only one option can be selected?</p>
                    <input type="radio" name="q5" value="a"> Use the same id <br>
                    <input type="radio" name="q5" value="b"> Use the same name <br>
                    <input type="radio" name="q5" value="c"> Use the same value <br>
                    <input type="radio" name="q5" value="d"> Use the same class <br>

                    <p>6. What does the &lt;label&gt; tag do?</p>
                    <input type="radio" name="q6" value="a"> Styles the input field <br>
                    <input type="radio" name="q6" value="b"> Describes the input field for accessibility <br>
                    <input type="radio" name="q6" value="c"> Makes the input required <br>
                    <input type="radio" name="q6" value="d"> Submits the form <br>

                    <p>7. Which tag creates a dropdown menu?</p>
                    <input type="radio" name="q7" value="a"> &lt;input type="select"&gt; <br>
                    <input type="radio" name="q7" value="b"> &lt;dropdown&gt; <br>
                    <input type="radio" name="q7" value="c"> &lt;select&gt; <br>
                    <input type="radio" name="q7" value="d"> &lt;option&gt; <br>

                    <p>8. What is the purpose of the "placeholder" attribute?</p>
                    <input type="radio" name="q8" value="a"> Displays a default hint inside the input box <br>
                    <input type="radio" name="q8" value="b"> Makes the input required <br>
                    <input type="radio" name="q8" value="c"> Connects the label to the input <br>
                    <input type="radio" name="q8" value="d"> Submits the form <br>

                    <p>9. Which &lt;input&gt; type allows the user to select multiple options independently?</p>
                    <input type="radio" name="q9" value="a"> radio <br>
                    <input type="radio" name="q9" value="b"> checkbox <br>
                    <input type="radio" name="q9" value="c"> text <br>
                    <input type="radio" name="q9" value="d"> file <br>

                    <p>10. Which method should be used to send sensitive information like passwords?</p>
                    <input type="radio" name="q10" value="a"> GET <br>
                    <input type="radio" name="q10" value="b"> POST <br>
                    <input type="radio" name="q10" value="c"> FILE <br>
                    <input type="radio" name="q10" value="d"> SELECT <br>
                    <br>
                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson3')
                {{-- ---- Lesson 3 Quiz ---- --}}
                <h2>Lesson 3 Quiz</h2>
                <form method="POST" action="{{ route('lesson3.submit') }}">
                    @csrf

                    <p>1. What does CSS stand for?</p>
                    <input type="radio" name="q1" value="a"> Cascading Style Sheets <br>
                    <input type="radio" name="q1" value="b"> Computer Style Sheets <br>
                    <input type="radio" name="q1" value="c"> Creative Style System <br>
                    <input type="radio" name="q1" value="d"> Colorful Style Sheets <br>

                    <p>2. What is the main purpose of CSS?</p>
                    <input type="radio" name="q2" value="a"> Structure content <br>
                    <input type="radio" name="q2" value="b"> Add interactivity <br>
                    <input type="radio" name="q2" value="c"> Style and design webpages <br>
                    <input type="radio" name="q2" value="d"> Store data <br>

                    <p>3. Which is the correct CSS syntax?</p>
                    <input type="radio" name="q3" value="a"> h1 = color:red; <br>
                    <input type="radio" name="q3" value="b"> h1 {color:red;} <br>
                    <input type="radio" name="q3" value="c"> h1:color=red; <br>
                    <input type="radio" name="q3" value="d"> {h1;color:red;} <br>

                    <p>4. Which type of CSS is applied directly in the HTML tag?</p>
                    <input type="radio" name="q4" value="a"> External <br>
                    <input type="radio" name="q4" value="b"> Internal <br>
                    <input type="radio" name="q4" value="c"> Inline <br>
                    <input type="radio" name="q4" value="d"> Global <br>

                    <p>5. Which tag is used for internal CSS?</p>
                    <input type="radio" name="q5" value="a"> &lt;script&gt; <br>
                    <input type="radio" name="q5" value="b"> &lt;css&gt; <br>
                    <input type="radio" name="q5" value="c"> &lt;style&gt; <br>
                    <input type="radio" name="q5" value="d"> &lt;link&gt; <br>

                    <p>6. Which is the best practice for large projects?</p>
                    <input type="radio" name="q6" value="a"> Inline CSS <br>
                    <input type="radio" name="q6" value="b"> Internal CSS <br>
                    <input type="radio" name="q6" value="c"> External CSS <br>
                    <input type="radio" name="q6" value="d"> Embedded CSS <br>

                    <p>7. What does px mean?</p>
                    <input type="radio" name="q7" value="a"> Percentage <br>
                    <input type="radio" name="q7" value="b"> Pixel <br>
                    <input type="radio" name="q7" value="c"> Point <br>
                    <input type="radio" name="q7" value="d"> Power <br>

                    <p>8. Which unit is relative to the parent element?</p>
                    <input type="radio" name="q8" value="a"> px <br>
                    <input type="radio" name="q8" value="b"> em <br>
                    <input type="radio" name="q8" value="c"> cm <br>
                    <input type="radio" name="q8" value="d"> pt <br>

                    <p>9. Which property changes text color?</p>
                    <input type="radio" name="q9" value="a"> background-color <br>
                    <input type="radio" name="q9" value="b"> text-style <br>
                    <input type="radio" name="q9" value="c"> color <br>
                    <input type="radio" name="q9" value="d"> font-color <br>

                    <p>10. Which property centers text?</p>
                    <input type="radio" name="q10" value="a"> align <br>
                    <input type="radio" name="q10" value="b"> text-align <br>
                    <input type="radio" name="q10" value="c"> center-text <br>
                    <input type="radio" name="q10" value="d"> position <br>
                    <br>
                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'lesson4')
                {{-- ---- Lesson 4 Practical Quiz ---- --}}
                <h2>Lesson 4 Practical Quiz</h2>
                <p>Create a <b>Hello World</b> text and change its color using CSS.</p>

                <textarea id="codeInput" rows="10" cols="60" placeholder="Type your HTML + CSS here..."></textarea>
                <br><br>
                <button onclick="checkCode()">Submit</button>
                <p id="result"></p>

                <script>
                    function checkCode() {
                        let code = document.getElementById("codeInput").value;
                        let hasText  = code.toLowerCase().includes("hello world");
                        let hasColor = code.toLowerCase().includes("color");

                        if (hasText && hasColor) {
                            document.getElementById("result").innerHTML = "✅ Passed!";
                            window.location.href = "{{ route('lesson4.pass') }}";
                        } else {
                            document.getElementById("result").innerHTML = "❌ Make sure you have 'Hello World' and applied color!";
                        }
                    }
                </script>

            @elseif($showQuiz === 'lesson5')
                {{-- ---- Lesson 5 Quiz (50 questions) ---- --}}
                <h2>Lesson 5 Quiz</h2>
                <form method="POST" action="{{ route('lesson5.submit') }}">
                    @csrf

                            <p>1. What is JavaScript mainly used for?</p>
        <input type="radio" name="q1" value="a"> Styling webpages<br>
        <input type="radio" name="q1" value="b"> Structuring content<br>
        <input type="radio" name="q1" value="c"> Adding interactivity and dynamic behavior<br>
        <input type="radio" name="q1" value="d"> Storing data in a database<br>

        <p>2. Which HTML tag is used to add JavaScript to a webpage?</p>
        <input type="radio" name="q2" value="a"> &lt;js&gt;<br>
        <input type="radio" name="q2" value="b"> &lt;script&gt;<br>
        <input type="radio" name="q2" value="c"> &lt;javascript&gt;<br>
        <input type="radio" name="q2" value="d"> &lt;code&gt;<br>

        <p>3. What is the correct way to link an external JavaScript file?</p>
        <input type="radio" name="q3" value="a"> &lt;script href="script.js"&gt;&lt;/script&gt;<br>
        <input type="radio" name="q3" value="b"> &lt;js src="script.js"&gt;<br>
        <input type="radio" name="q3" value="c"> &lt;script src="script.js"&gt;&lt;/script&gt;<br>
        <input type="radio" name="q3" value="d"> &lt;link src="script.js"&gt;<br>

        <p>4. Which method is used to select an HTML element by its ID?</p>
        <input type="radio" name="q4" value="a"> document.querySelector()<br>
        <input type="radio" name="q4" value="b"> document.getElement()<br>
        <input type="radio" name="q4" value="c"> document.selectById()<br>
        <input type="radio" name="q4" value="d"> document.getElementById()<br>

        <p>5. Which method can select an element using a class name?</p>
        <input type="radio" name="q5" value="a"> document.getElementById()<br>
        <input type="radio" name="q5" value="b"> document.querySelector()<br>
        <input type="radio" name="q5" value="c"> document.getClass()<br>
        <input type="radio" name="q5" value="d"> document.selectClass()<br>

        <p>6. How do you change the text of an element with id="demo" using JavaScript?</p>
        <input type="radio" name="q6" value="a"> document.getElementById("demo").style = "Hello"<br>
        <input type="radio" name="q6" value="b"> document.getElementById("demo").text = "Hello"<br>
        <input type="radio" name="q6" value="c"> document.getElementById("demo").innerHTML = "Hello"<br>
        <input type="radio" name="q6" value="d"> document.getElementById("demo").value = "Hello"<br>

        <p>7. How do you change the text color of an element to red using JavaScript?</p>
        <input type="radio" name="q7" value="a"> document.getElementById("demo").color = "red"<br>
        <input type="radio" name="q7" value="b"> document.getElementById("demo").style.color = "red"<br>
        <input type="radio" name="q7" value="c"> document.getElementById("demo").css.color = "red"<br>
        <input type="radio" name="q7" value="d"> document.getElementById("demo").font = "red"<br>

        <p>8. Which of the following is a JavaScript event?</p>
        <input type="radio" name="q8" value="a"> oncolor<br>
        <input type="radio" name="q8" value="b"> onstyle<br>
        <input type="radio" name="q8" value="c"> onclick<br>
        <input type="radio" name="q8" value="d"> onsize<br>

        <p>9. What is the correct way to call a function when a button is clicked using an event handler?</p>
        <input type="radio" name="q9" value="a"> &lt;button onpress="myFunc()"&gt;Click&lt;/button&gt;<br>
        <input type="radio" name="q9" value="b"> &lt;button click="myFunc()"&gt;Click&lt;/button&gt;<br>
        <input type="radio" name="q9" value="c"> &lt;button onclick="myFunc()"&gt;Click&lt;/button&gt;<br>
        <input type="radio" name="q9" value="d"> &lt;button run="myFunc()"&gt;Click&lt;/button&gt;<br>

        <p>10. What is the recommended way to handle events in JavaScript?</p>
        <input type="radio" name="q10" value="a"> Using onclick inside the HTML tag<br>
        <input type="radio" name="q10" value="b"> Using addEventListener() inside JavaScript<br>
        <input type="radio" name="q10" value="c"> Using onpress inside the HTML tag<br>
        <input type="radio" name="q10" value="d"> Using style attributes<br>

        <br>


                    <button type="submit">Submit</button>
                </form>

            @elseif($showQuiz === 'final')
                {{-- ---- Final Exam (50 questions covering all lessons) ---- --}}
                <h2>🎓 Final Exam</h2>
                <p>This exam covers all lessons: HTML, CSS, and JavaScript. Answer all 50 questions.</p>

                <form method="POST" action="{{ route('final.submit') }}">
                    @csrf

                    {{-- HTML Questions (1–17) --}}
                    <h3>— HTML —</h3>

                    <p>1. What does HTML stand for?</p>
                    <input type="radio" name="q1" value="a"> HyperText Markup Language<br>
                    <input type="radio" name="q1" value="b"> Home Tool Markup Language<br>
                    <input type="radio" name="q1" value="c"> Hyperlinks and Text Markup Language<br>
                    <input type="radio" name="q1" value="d"> HyperText Makeup Language<br><br>

                    <p>2. Which tag is used for paragraphs?</p>
                    <input type="radio" name="q2" value="a"> &lt;p&gt;<br>
                    <input type="radio" name="q2" value="b"> &lt;h1&gt;<br>
                    <input type="radio" name="q2" value="c"> &lt;div&gt;<br>
                    <input type="radio" name="q2" value="d"> &lt;span&gt;<br><br>

                    <p>3. Which tag is used to display an image?</p>
                    <input type="radio" name="q3" value="a"> &lt;image&gt;<br>
                    <input type="radio" name="q3" value="b"> &lt;img&gt;<br>
                    <input type="radio" name="q3" value="c"> &lt;picture&gt;<br>
                    <input type="radio" name="q3" value="d"> &lt;figure&gt;<br><br>

                    <p>4. Which tag creates a hyperlink?</p>
                    <input type="radio" name="q4" value="a"> &lt;link&gt;<br>
                    <input type="radio" name="q4" value="b"> &lt;href&gt;<br>
                    <input type="radio" name="q4" value="c"> &lt;a&gt;<br>
                    <input type="radio" name="q4" value="d"> &lt;url&gt;<br><br>

                    <p>5. Where is the visible webpage content placed?</p>
                    <input type="radio" name="q5" value="a"> &lt;head&gt;<br>
                    <input type="radio" name="q5" value="b"> &lt;title&gt;<br>
                    <input type="radio" name="q5" value="c"> &lt;body&gt;<br>
                    <input type="radio" name="q5" value="d"> &lt;meta&gt;<br><br>

                    <p>6. Which syntax is correct for HTML comments?</p>
                    <input type="radio" name="q6" value="a"> // comment<br>
                    <input type="radio" name="q6" value="b"> /* comment */<br>
                    <input type="radio" name="q6" value="c"> &lt;!-- comment --&gt;<br>
                    <input type="radio" name="q6" value="d"> # comment<br><br>

                    <p>7. Which tag represents the largest heading?</p>
                    <input type="radio" name="q7" value="a"> &lt;h6&gt;<br>
                    <input type="radio" name="q7" value="b"> &lt;heading&gt;<br>
                    <input type="radio" name="q7" value="c"> &lt;head&gt;<br>
                    <input type="radio" name="q7" value="d"> &lt;h1&gt;<br><br>

                    <p>8. Which tag is used to create a form?</p>
                    <input type="radio" name="q8" value="a"> &lt;input&gt;<br>
                    <input type="radio" name="q8" value="b"> &lt;form&gt;<br>
                    <input type="radio" name="q8" value="c"> &lt;label&gt;<br>
                    <input type="radio" name="q8" value="d"> &lt;textarea&gt;<br><br>

                    <p>9. Which attribute specifies the image source?</p>
                    <input type="radio" name="q9" value="a"> href<br>
                    <input type="radio" name="q9" value="b"> link<br>
                    <input type="radio" name="q9" value="c"> alt<br>
                    <input type="radio" name="q9" value="d"> src<br><br>

                    <p>10. Which tag creates a line break?</p>
                    <input type="radio" name="q10" value="a"> &lt;break&gt;<br>
                    <input type="radio" name="q10" value="b"> &lt;hr&gt;<br>
                    <input type="radio" name="q10" value="c"> &lt;br&gt;<br>
                    <input type="radio" name="q10" value="d"> &lt;lb&gt;<br><br>

                    <p>11. Which tag creates an unordered list?</p>
                    <input type="radio" name="q11" value="a"> &lt;ol&gt;<br>
                    <input type="radio" name="q11" value="b"> &lt;li&gt;<br>
                    <input type="radio" name="q11" value="c"> &lt;ul&gt;<br>
                    <input type="radio" name="q11" value="d"> &lt;list&gt;<br><br>

                    <p>12. Which tag creates an ordered list?</p>
                    <input type="radio" name="q12" value="a"> &lt;ul&gt;<br>
                    <input type="radio" name="q12" value="b"> &lt;ol&gt;<br>
                    <input type="radio" name="q12" value="c"> &lt;li&gt;<br>
                    <input type="radio" name="q12" value="d"> &lt;list&gt;<br><br>

                    <p>13. Which &lt;input&gt; type hides typed characters?</p>
                    <input type="radio" name="q13" value="a"> text<br>
                    <input type="radio" name="q13" value="b"> hidden<br>
                    <input type="radio" name="q13" value="c"> password<br>
                    <input type="radio" name="q13" value="d"> secret<br><br>

                    <p>14. Which element creates a multi-line text input?</p>
                    <input type="radio" name="q14" value="a"> &lt;input type="text"&gt;<br>
                    <input type="radio" name="q14" value="b"> &lt;select&gt;<br>
                    <input type="radio" name="q14" value="c"> &lt;textarea&gt;<br>
                    <input type="radio" name="q14" value="d"> &lt;button&gt;<br><br>

                    <p>15. Which tag creates a dropdown menu?</p>
                    <input type="radio" name="q15" value="a"> &lt;input type="select"&gt;<br>
                    <input type="radio" name="q15" value="b"> &lt;dropdown&gt;<br>
                    <input type="radio" name="q15" value="c"> &lt;option&gt;<br>
                    <input type="radio" name="q15" value="d"> &lt;select&gt;<br><br>

                    <p>16. Which attribute is required when using &lt;input type="file"&gt;?</p>
                    <input type="radio" name="q16" value="a"> method="GET"<br>
                    <input type="radio" name="q16" value="b"> enctype="multipart/form-data"<br>
                    <input type="radio" name="q16" value="c"> placeholder<br>
                    <input type="radio" name="q16" value="d"> action<br><br>

                    <p>17. Which method sends sensitive form data securely?</p>
                    <input type="radio" name="q17" value="a"> GET<br>
                    <input type="radio" name="q17" value="b"> FILE<br>
                    <input type="radio" name="q17" value="c"> SELECT<br>
                    <input type="radio" name="q17" value="d"> POST<br><br>

                    {{-- CSS Questions (18–34) --}}
                    <h3>— CSS —</h3>

                    <p>18. What does CSS stand for?</p>
                    <input type="radio" name="q18" value="a"> Computer Style Sheets<br>
                    <input type="radio" name="q18" value="b"> Cascading Style Sheets<br>
                    <input type="radio" name="q18" value="c"> Creative Style Syntax<br>
                    <input type="radio" name="q18" value="d"> Color Style Sheet<br><br>

                    <p>19. What is the main purpose of CSS?</p>
                    <input type="radio" name="q19" value="a"> Structure content<br>
                    <input type="radio" name="q19" value="b"> Add interactivity<br>
                    <input type="radio" name="q19" value="c"> Style and design webpages<br>
                    <input type="radio" name="q19" value="d"> Store data<br><br>

                    <p>20. Which is the correct CSS syntax?</p>
                    <input type="radio" name="q20" value="a"> h1 = color:red;<br>
                    <input type="radio" name="q20" value="b"> h1 {color:red;}<br>
                    <input type="radio" name="q20" value="c"> h1:color=red;<br>
                    <input type="radio" name="q20" value="d"> {h1;color:red;}<br><br>

                    <p>21. Which type of CSS is applied directly inside the HTML tag?</p>
                    <input type="radio" name="q21" value="a"> External<br>
                    <input type="radio" name="q21" value="b"> Internal<br>
                    <input type="radio" name="q21" value="c"> Inline<br>
                    <input type="radio" name="q21" value="d"> Global<br><br>

                    <p>22. Which tag is used for internal CSS?</p>
                    <input type="radio" name="q22" value="a"> &lt;script&gt;<br>
                    <input type="radio" name="q22" value="b"> &lt;css&gt;<br>
                    <input type="radio" name="q22" value="c"> &lt;style&gt;<br>
                    <input type="radio" name="q22" value="d"> &lt;link&gt;<br><br>

                    <p>23. Which is best practice for large projects?</p>
                    <input type="radio" name="q23" value="a"> Inline CSS<br>
                    <input type="radio" name="q23" value="b"> Internal CSS<br>
                    <input type="radio" name="q23" value="c"> External CSS<br>
                    <input type="radio" name="q23" value="d"> Embedded CSS<br><br>

                    <p>24. What does px mean in CSS?</p>
                    <input type="radio" name="q24" value="a"> Percentage<br>
                    <input type="radio" name="q24" value="b"> Point<br>
                    <input type="radio" name="q24" value="c"> Pixel<br>
                    <input type="radio" name="q24" value="d"> Power<br><br>

                    <p>25. Which unit is relative to the parent element's font size?</p>
                    <input type="radio" name="q25" value="a"> px<br>
                    <input type="radio" name="q25" value="b"> cm<br>
                    <input type="radio" name="q25" value="c"> pt<br>
                    <input type="radio" name="q25" value="d"> em<br><br>

                    <p>26. Which property changes text color?</p>
                    <input type="radio" name="q26" value="a"> background-color<br>
                    <input type="radio" name="q26" value="b"> text-style<br>
                    <input type="radio" name="q26" value="c"> color<br>
                    <input type="radio" name="q26" value="d"> font-color<br><br>

                    <p>27. Which property changes the background color?</p>
                    <input type="radio" name="q27" value="a"> bg-color<br>
                    <input type="radio" name="q27" value="b"> back-color<br>
                    <input type="radio" name="q27" value="c"> color-background<br>
                    <input type="radio" name="q27" value="d"> background-color<br><br>

                    <p>28. Which property centers text?</p>
                    <input type="radio" name="q28" value="a"> align<br>
                    <input type="radio" name="q28" value="b"> text-align<br>
                    <input type="radio" name="q28" value="c"> center-text<br>
                    <input type="radio" name="q28" value="d"> position<br><br>

                    <p>29. What does the opacity property control?</p>
                    <input type="radio" name="q29" value="a"> size<br>
                    <input type="radio" name="q29" value="b"> color<br>
                    <input type="radio" name="q29" value="c"> transparency<br>
                    <input type="radio" name="q29" value="d"> position<br><br>

                    <p>30. What is the opacity range?</p>
                    <input type="radio" name="q30" value="a"> 1 to 10<br>
                    <input type="radio" name="q30" value="b"> 0 to 100<br>
                    <input type="radio" name="q30" value="c"> 0 to 1<br>
                    <input type="radio" name="q30" value="d"> 1 to 1000<br><br>

                    <p>31. Opacity value 0 means?</p>
                    <input type="radio" name="q31" value="a"> fully visible<br>
                    <input type="radio" name="q31" value="b"> half visible<br>
                    <input type="radio" name="q31" value="c"> invisible<br>
                    <input type="radio" name="q31" value="d"> bold text<br><br>

                    <p>32. Opacity value 1 means?</p>
                    <input type="radio" name="q32" value="a"> invisible<br>
                    <input type="radio" name="q32" value="b"> fully visible<br>
                    <input type="radio" name="q32" value="c"> transparent<br>
                    <input type="radio" name="q32" value="d"> hidden<br><br>

                    <p>33. Which property adds space inside an element?</p>
                    <input type="radio" name="q33" value="a"> margin<br>
                    <input type="radio" name="q33" value="b"> border<br>
                    <input type="radio" name="q33" value="c"> padding<br>
                    <input type="radio" name="q33" value="d"> spacing<br><br>

                    <p>34. Which property adds space outside an element?</p>
                    <input type="radio" name="q34" value="a"> padding<br>
                    <input type="radio" name="q34" value="b"> border<br>
                    <input type="radio" name="q34" value="c"> margin<br>
                    <input type="radio" name="q34" value="d"> spacing<br><br>

                    {{-- JavaScript Questions (35–50) --}}
                    <h3>— JavaScript —</h3>

                    <p>35. What is JavaScript mainly used for?</p>
                    <input type="radio" name="q35" value="a"> Structure webpage<br>
                    <input type="radio" name="q35" value="b"> Styling webpage<br>
                    <input type="radio" name="q35" value="c"> Interactivity<br>
                    <input type="radio" name="q35" value="d"> Database design<br><br>

                    <p>36. Which tag is used to insert JavaScript in HTML?</p>
                    <input type="radio" name="q36" value="a"> &lt;css&gt;<br>
                    <input type="radio" name="q36" value="b"> &lt;js&gt;<br>
                    <input type="radio" name="q36" value="c"> &lt;script&gt;<br>
                    <input type="radio" name="q36" value="d"> &lt;javascript&gt;<br><br>

                    <p>37. Which event runs when a button is clicked?</p>
                    <input type="radio" name="q37" value="a"> onchange<br>
                    <input type="radio" name="q37" value="b"> onclick<br>
                    <input type="radio" name="q37" value="c"> onload<br>
                    <input type="radio" name="q37" value="d"> onsubmit<br><br>

                    <p>38. Which method selects an element by ID?</p>
                    <input type="radio" name="q38" value="a"> getElementById<br>
                    <input type="radio" name="q38" value="b"> getElementsByClass<br>
                    <input type="radio" name="q38" value="c"> querySelectAll<br>
                    <input type="radio" name="q38" value="d"> getTagById<br><br>

                    <p>39. What does DOM stand for?</p>
                    <input type="radio" name="q39" value="a"> Document Object Model<br>
                    <input type="radio" name="q39" value="b"> Data Object Model<br>
                    <input type="radio" name="q39" value="c"> Digital Output Model<br>
                    <input type="radio" name="q39" value="d"> Document Output Mode<br><br>

                    <p>40. Which symbol is used for single-line comments in JavaScript?</p>
                    <input type="radio" name="q40" value="a"> &lt;!-- --&gt;<br>
                    <input type="radio" name="q40" value="b"> #<br>
                    <input type="radio" name="q40" value="c"> //<br>
                    <input type="radio" name="q40" value="d"> **<br><br>

                    <p>41. Which keyword declares a variable (old way)?</p>
                    <input type="radio" name="q41" value="a"> var<br>
                    <input type="radio" name="q41" value="b"> define<br>
                    <input type="radio" name="q41" value="c"> create<br>
                    <input type="radio" name="q41" value="d"> int<br><br>

                    <p>42. Which keyword is the modern way to declare a variable?</p>
                    <input type="radio" name="q42" value="a"> var<br>
                    <input type="radio" name="q42" value="b"> let<br>
                    <input type="radio" name="q42" value="c"> define<br>
                    <input type="radio" name="q42" value="d"> float<br><br>

                    <p>43. Which keyword declares a constant?</p>
                    <input type="radio" name="q43" value="a"> const<br>
                    <input type="radio" name="q43" value="b"> let<br>
                    <input type="radio" name="q43" value="c"> var<br>
                    <input type="radio" name="q43" value="d"> static<br><br>

                    <p>44. Which function shows a popup message box?</p>
                    <input type="radio" name="q44" value="a"> alert()<br>
                    <input type="radio" name="q44" value="b"> show()<br>
                    <input type="radio" name="q44" value="c"> popup()<br>
                    <input type="radio" name="q44" value="d"> message()<br><br>

                    <p>45. Which function logs output to the console?</p>
                    <input type="radio" name="q45" value="a"> print()<br>
                    <input type="radio" name="q45" value="b"> console.log()<br>
                    <input type="radio" name="q45" value="c"> log.print()<br>
                    <input type="radio" name="q45" value="d"> debug()<br><br>

                    <p>46. Which operator checks strict equality (value AND type)?</p>
                    <input type="radio" name="q46" value="a"> =<br>
                    <input type="radio" name="q46" value="b"> ==<br>
                    <input type="radio" name="q46" value="c"> ===<br>
                    <input type="radio" name="q46" value="d"> !=<br><br>

                    <p>47. Which is the correct function syntax in JavaScript?</p>
                    <input type="radio" name="q47" value="a"> function myFunc() {}<br>
                    <input type="radio" name="q47" value="b"> func myFunc {}<br>
                    <input type="radio" name="q47" value="c"> def myFunc()<br>
                    <input type="radio" name="q47" value="d"> function:myFunc()<br><br>

                    <p>48. Which keyword stops a loop?</p>
                    <input type="radio" name="q48" value="a"> stop<br>
                    <input type="radio" name="q48" value="b"> exit<br>
                    <input type="radio" name="q48" value="c"> break<br>
                    <input type="radio" name="q48" value="d"> end<br><br>

                    <p>49. Which event listens to an input change?</p>
                    <input type="radio" name="q49" value="a"> onclick<br>
                    <input type="radio" name="q49" value="b"> onload<br>
                    <input type="radio" name="q49" value="c"> onchange<br>
                    <input type="radio" name="q49" value="d"> onhover<br><br>

                    <p>50. What is the correct way to include an external JS file?</p>
                    <input type="radio" name="q50" value="a"> &lt;script src="app.js"&gt;&lt;/script&gt;<br>
                    <input type="radio" name="q50" value="b"> &lt;js src="app.js"&gt;<br>
                    <input type="radio" name="q50" value="c"> &lt;link src="app.js"&gt;<br>
                    <input type="radio" name="q50" value="d"> &lt;javascript href="app.js"&gt;<br><br>

                    <button type="submit">Submit Final Exam</button>
                </form>

            @endif {{-- end quiz sections --}}

        </div>
    </div>

</body>

</html>
