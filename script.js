// FEATURED TOYS FILTERING

var featuredFilterButtons = document.querySelectorAll("#filters button");
var toyCards = document.querySelectorAll("#grid .card");

featuredFilterButtons.forEach(function(button) {

    button.onclick = function() {

        featuredFilterButtons.forEach(function(btn) {
            btn.classList.remove("active");
        });
        button.classList.add("active");

        var category = button.getAttribute("data-cat");

        for (var i = 0; i < toyCards.length; i++) {

            var toyCategory = toyCards[i].getAttribute("data-cat");

            if (category == "all" || category == toyCategory) {

                toyCards[i].style.display = "block";

            } else {

                toyCards[i].style.display = "none";

            }
        }

    };

});

// CATEGORY FILTERING

var categoryFilterButtons = document.querySelectorAll(".filter-btn");
var categoryCards = document.querySelectorAll(".category-card");

categoryFilterButtons.forEach(function(button) {

    button.onclick = function() {

        categoryFilterButtons.forEach(function(btn) {
            btn.classList.remove("active");
        });
        button.classList.add("active");

        var selectedCategory = button.getAttribute("data-filter");

        for (var i = 0; i < categoryCards.length; i++) {

            var cardCategory = categoryCards[i].getAttribute("data-filter-group");

            if (selectedCategory == "all" || selectedCategory == cardCategory) {

                categoryCards[i].style.display = "block";

            } else {

                categoryCards[i].style.display = "none";

            }

        }

    };

});

// DYNAMIC TOY CARDS (ONLY RUNS WHEN A REAL <template> IS PRESENT)

var toyData = [

    {
        image: "images/toy1.jpg",
        thumb1: "images/toy1-1.jpg",
        thumb2: "images/toy1-2.jpg",
        name: "Superhero Action Figure",
        brand: "Marvel",
        description: "A superhero action figure with movable parts.",
        model: "models/toy1.glb"
    },

    {
        image: "images/toy2.jpg",
        thumb1: "images/toy2-1.jpg",
        thumb2: "images/toy2-2.jpg",
        name: "Robot Action Figure",
        brand: "Hasbro",
        description: "A robot figure designed for imaginative play.",
        model: "models/toy2.glb"
    }

];

var container = document.getElementById("toy-details-container");
var template = document.getElementById("toy-card-template");

if (container && template && template.tagName === "TEMPLATE" && template.content) {

    for (var i = 0; i < toyData.length; i++) {

        var toyCard = template.content.cloneNode(true);

        var mainImg = toyCard.querySelector(".toy-main-img");
        var thumb1 = toyCard.querySelector(".toy-thumb-1");
        var thumb2 = toyCard.querySelector(".toy-thumb-2");
        var nameEl = toyCard.querySelector(".toy-name");
        var brandEl = toyCard.querySelector(".toy-brand");
        var descEl = toyCard.querySelector(".toy-description");

        if (mainImg) mainImg.src = toyData[i].image;
        if (thumb1) thumb1.src = toyData[i].thumb1;
        if (thumb2) thumb2.src = toyData[i].thumb2;
        if (nameEl) nameEl.textContent = toyData[i].name;
        if (brandEl) brandEl.textContent = toyData[i].brand;
        if (descEl) descEl.textContent = toyData[i].description;

        var viewerFrame = toyCard.querySelector(".toy-3d-frame");

        if (viewerFrame && toyData[i].model != "") {

            var viewer = document.createElement("model-viewer");

            viewer.setAttribute("src", toyData[i].model);
            viewer.setAttribute("camera-controls", "");
            viewer.setAttribute("auto-rotate", "");

            viewerFrame.appendChild(viewer);

        }

        container.appendChild(toyCard);

    }

}

// NAME VALIDATION

function checkName() {

    var name = document.getElementById("name").value;

    if (name.trim() == "") {

        document.getElementById("name-status").innerHTML = "Please enter your name.";

        return false;

    } else {

        document.getElementById("name-status").innerHTML = "Valid name.";

        return true;

    }

}


// GENDER VALIDATION

function checkGender() {

    var gender = document.querySelector('input[name="gender"]:checked');

    if (gender == null) {

        document.getElementById("gender-status").innerHTML = "Please select your gender.";

        return false;

    } else {

        document.getElementById("gender-status").innerHTML = "Gender selected.";

        return true;

    }

}


// EMAIL VALIDATION

function checkEmail() {

    var email = document.getElementById("email").value;

    var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email == "") {

        document.getElementById("email-status").innerHTML = "Please enter your email.";

        return false;

    } else if (!pattern.test(email)) {

        document.getElementById("email-status").innerHTML = "Invalid email format.";

        return false;

    } else {

        document.getElementById("email-status").innerHTML = "Valid email.";

        return true;

    }

}


// FEEDBACK TYPE VALIDATION

function checkType() {

    var type = document.getElementById("feedback-type").value;

    if (type == "") {

        document.getElementById("type-status").innerHTML = "Please select feedback type.";

        return false;

    } else {

        document.getElementById("type-status").innerHTML = "Feedback type selected.";

        return true;

    }

}


// FEEDBACK MESSAGE VALIDATION

function checkFeedback() {

    var feedback = document.getElementById("feedback-message").value;

    if (feedback.trim() == "") {

        document.getElementById("feedback-status").innerHTML = "Please enter your feedback.";

        return false;

    } else {

        document.getElementById("feedback-status").innerHTML = "Feedback submitted.";

        return true;

    }

}


// FORM SUBMISSION VALIDATION

var feedbackForm = document.getElementById("feedback-form");

if (feedbackForm) {

    feedbackForm.onsubmit = function() {

        var validName = checkName();

        var validGender = checkGender();

        var validEmail = checkEmail();

        var validType = checkType();

        var validFeedback = checkFeedback();

        if (validName && validGender && validEmail && validType && validFeedback) {

            window.alert("Thank you for your feedback!");

            return true;

        } else {

            window.alert("Please complete all required fields correctly.");

            return false;

        }

    };

}

// SHELL MUSIC BRIDGE (WHEN INSIDE shell.html)

var musicButtons = document.querySelectorAll(".music-toggle-btn");
var localBgMusic = document.getElementById("bg-music");

function setMusicButtonLabels(isPlaying) {
    var label = isPlaying ? "Pause Music" : "Play Music";
    musicButtons.forEach(function(btn) {
        btn.textContent = label;
    });
}

if (musicButtons.length > 0) {
    if (window.parent && window.parent !== window) {
        musicButtons.forEach(function(btn) {
            btn.onclick = function() {
                window.parent.postMessage({ type: "TOGGLE_MUSIC" }, "*");
            };
        });

        window.addEventListener("message", function(event) {
            if (event.data && event.data.type === "MUSIC_STATE") {
                setMusicButtonLabels(Boolean(event.data.isPlaying));
            }
        });

        window.parent.postMessage({ type: "GET_MUSIC_STATE" }, "*");
    } else if (localBgMusic) {
        localBgMusic.volume = 0.25;
        musicButtons.forEach(function(btn) {
            btn.onclick = function() {
                if (localBgMusic.paused) {
                    localBgMusic.play().then(function() {
                        setMusicButtonLabels(true);
                    }).catch(function() {});
                } else {
                    localBgMusic.pause();
                    setMusicButtonLabels(false);
                }
            };
        });
        setMusicButtonLabels(!localBgMusic.paused);
    }
}