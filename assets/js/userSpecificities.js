let inputPlayingWay=document.getElementsByClassName('playing-way-select-button')
let elementsPlayingWay=document.getElementById('user_specificities_form_playingWay').children
let radioButtonsPlayingWay=[]
let roleFlexibilityBlock=document.getElementById('role-flexibility-selection-block')
let classFlexibilityBlock=document.getElementById('class-flexibility-selection-block')
let speakEnglishBlock=document.getElementById('speak-english-selection-block')
for (let i =0 ; i < elementsPlayingWay.length ; i++) {
    if (elementsPlayingWay[i].tagName === 'INPUT') {
        radioButtonsPlayingWay.push(elementsPlayingWay[i])
    }
}
for (let i=0 ; i < inputPlayingWay.length ; i++) {
    inputPlayingWay[i].addEventListener('click', function(){
        radioButtonsPlayingWay[i].checked = true
        roleFlexibilityBlock.classList.remove('hidden')
    })
}

let inputRoleFlexibility=document.getElementsByClassName('role-flexibility-select-button')
let elementsRoleFlexibility=document.getElementById('user_specificities_form_roleFlexibility').children
let radioButtonsRoleFlexibility=[]
for (let i =0 ; i < elementsRoleFlexibility.length ; i++) {
    if (elementsRoleFlexibility[i].tagName === 'INPUT') {
        radioButtonsRoleFlexibility.push(elementsRoleFlexibility[i])
    }
}
for (let i=0 ; i < inputRoleFlexibility.length ; i++) {
    console.log(radioButtonsRoleFlexibility[i])
    console.log(inputRoleFlexibility[i])
    inputRoleFlexibility[i].addEventListener('click', function(){

        radioButtonsRoleFlexibility[i].checked = true
        classFlexibilityBlock.classList.remove('hidden')
    })
}

let inputClassFlexibility=document.getElementsByClassName('class-flexibility-select-button')
let elementsClassFlexibility=document.getElementById('user_specificities_form_classFlexibility').children
let radioButtonsClassFlexibility=[]
for (let i =0 ; i < elementsClassFlexibility.length ; i++) {
    if (elementsClassFlexibility[i].tagName === 'INPUT') {
        radioButtonsClassFlexibility.push(elementsClassFlexibility[i])
    }
}
for (let i=0 ; i < inputClassFlexibility.length ; i++) {
    inputClassFlexibility[i].addEventListener('click', function(){
        radioButtonsClassFlexibility[i].checked = true
        speakEnglishBlock.classList.remove('hidden')
    })
}

let inputSpeakEnglish=document.getElementsByClassName('speak-english-select-button')
let elementsSpeakEnglish = document.getElementById('user_specificities_form_speakEnglish').children
let radioButtonsSpeakEnglish=[]
for (let i =0 ; i < elementsSpeakEnglish.length ; i++) {
    if (elementsSpeakEnglish[i].tagName === 'INPUT') {
        radioButtonsSpeakEnglish.push(elementsSpeakEnglish[i])
    }
}
for (let i=0 ; i < inputSpeakEnglish.length ; i++) {
    inputSpeakEnglish[i].addEventListener('click', function(){
        radioButtonsSpeakEnglish[i].checked = true
    })
}


