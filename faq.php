<?php
include 'header.php';
include 'navbar.php';
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- fontawasome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- css -->
    <link href="faqstyle.css" rel="stylesheet" type="text/css">
</head>

<body>

    <section>
        <h1 class="title">FAQ's</h1>

        <div class="questions-container">
            <div class="question">
                <button>
                    <span>How do I start a secret conversation?</span>
                    <i class="fas fa-chevron-down d-arrow"></i>
                </button>
                <p>This platform offers you to have a secret conversation,i.e. you are already having a secret conversation,no other person can invade your privacy. This site is created by keeping users privacy in mind.</p>
            </div>

            <div class="question">
                <button>
                    <span>What should I do if someone's bothering me in chat?</span>
                    <i class="fas fa-chevron-down d-arrow"></i>
                </button>
                <p>Regarding this problem just inform us the name of the user who is bothering you,we will make sure it doesn't happen again.<br>Click this 
                <a href="mailto:custoomers.info@gmail.com">Customer Support</a> or mail us to: custoomers.info@gmail.com</p>
                
            </div>

            <div class="question">
                <button>
                    <span>How can I change my details or update them?</span>
                    <i class="fas fa-chevron-down d-arrow"></i>
                </button>
                <p>•Login to you account.<br>•Click Settings button.<br>•Update your informations.<br>•Click Save button.</p>
            </div>

            <div class="question">
                <button>
                    <span>How to add friends? / How to Chat?</span>
                    <i class="fas fa-chevron-down d-arrow"></i>
                </button>
                <p>•Login to your account.<br>•On the right top corner,you will find a search box, type your friends name.<br>•Suggestions will come, find your friend and click 'connect'. After your friend accept your friend request you can chat.<br>•Now on the left side of the page you will notice your friends name, click 'Start Chat' and start chatting.</p>
            </div>
        </div>
    </section>

    <!-- external js-->
    <script>
        const buttons = document.querySelectorAll('button');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const faq = button.nextElementSibling;
                const icon = button.children[1];

                faq.classList.toggle('show');
                icon.classList.toggle('rotate');
            })
        })
    </script>
</body>

</html>
<?php
include 'footer.php';
?>