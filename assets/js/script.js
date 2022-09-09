try {
    var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    var recognition = new SpeechRecognition();
} catch (e) {
    console.error(e);
    $('.no-browser-support').show();
    $('.app').hide();
}


var noteTextarea = $('#note-textarea');
var instructions = $('#recording-instructions');
var notesList = $('ul#notes');

var noteContent = '';

// Get all notes from previous sessions and display them.
// var notes = getAllNotes();
// renderNotes(notes);



/*-----------------------------
      Voice Recognition 
------------------------------*/

// If false, the recording will stop after a few seconds of silence.
// When true, the silence period is longer (about 15 seconds),
// allowing us to keep recording even when the user pauses. 
recognition.continuous = true;

// This block is called every time the Speech APi captures a line. 
recognition.onresult = function(event) {

    // event is a SpeechRecognitionEvent object.
    // It holds all the lines we have captured so far. 
    // We only need the current one.
    var current = event.resultIndex;

    // Get a transcript of what was said.
    var transcript = event.results[current][0].transcript;

    // Add the current transcript to the contents of our Note.
    // There is a weird bug on mobile, where everything is repeated twice.
    // There is no official solution so far so we have to handle an edge case.
    var mobileRepeatBug = (current == 1 && transcript == event.results[0][0].transcript);

    if (!mobileRepeatBug) {
        noteContent += transcript;
        // console.log(noteContent);
        noteTextarea.val(noteContent);
    }
    $('#start-record-btn').removeAttr('disabled');
    document.getElementById("start-record-btn").style.opacity = 1;
};

recognition.onstart = function() {
     instructions.text('Voice recognition activated. Try speaking into the microphone.');
     $('#start-record-btn').attr('disabled','disabled');
    document.getElementById("start-record-btn").style.opacity = 0.2;
}

recognition.onspeechend = function() {
     instructions.text('You were quiet for a while so voice recognition turned itself off.');
     $('#start-record-btn').removeAttr('disabled');
    document.getElementById("start-record-btn").style.opacity = 1;
}

recognition.onerror = function(event) {
    if (event.error == 'no-speech') {
        instructions.text('No speech was detected. Try again.');
    };
    $('#start-record-btn').removeAttr('disabled');
    document.getElementById("start-record-btn").style.opacity = 1;
}



/*-----------------------------
      App buttons and input 
------------------------------*/

$('#start-record-btn').on('click', function(e) {

    if (noteContent.length) {
        noteContent += ' ';
    }
    $('#start-record-btn').attr('disabled','disabled');
    document.getElementById("start-record-btn").style.opacity = 0.2;
    recognition.start();
});


$('#pause-record-btn').on('click', function(e) {
    recognition.stop();
    instructions.text('Voice recognition paused.');
    $('#start-record-btn').removeAttr('disabled');
    document.getElementById("start-record-btn").style.opacity = 1;
});

// Sync the text inside the text area with the noteContent variable.
noteTextarea.on('input', function() {
    noteContent = $(this).val();
})



