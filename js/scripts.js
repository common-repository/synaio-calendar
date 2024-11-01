
// https://youtu.be/r9ay2FMfbJw
window.onload = () => {
    
    var evenements = [];
    let evt_json = JSON.parse(atob($webresult));
    console.log(evt_json);
    for(var i = 0; i < evt_json.length; i++) {
        var color;
        var obj = evt_json[i];
        
        if(obj.atelierCouleur === null && obj.evenementCouleur === null)
            color = "green";
        else if(obj.atelierCouleur != null && obj.evenementCouleur === null)
            color = obj.atelierCouleur;
        else if(obj.atelierCouleur === null && obj.evenementCouleur != null)
            color = obj.evenementCouleur;


        console.log(obj.evenement);

let eventItem = '{"title": "'+obj.atelierTitre+'",    "start": "'+obj.atelierDateDebut+'",    "end": "'+obj.atelierDateFin+'",    "backgroundColor": "'+color+'"}';

evenements.push(JSON.parse(eventItem));
}
    console.log(evenements);
    //console.log(evenements2);
    let elementCalendrier = document.getElementById("calendrier")
    
    // Calendar instantiation
    let calendrier = new FullCalendar.Calendar(elementCalendrier, {
        // Composants call
        plugins: ['dayGrid', 'timeGrid', 'list', 'interaction'],
        defaultView: 'timeGridWeek',
        local: 'fr',
        firstDay: 1,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,list'
        },
        buttonText: {
            today: 'Aujourd\'hui',
            week: 'Semaine',
            month: 'Mois',
            list: 'Jour'
        },
        nowIndicator: true,
        events: evenements,
        // Log infos when event is moved
        eventDrop: (infos) => {
            console.log(infos)
            // Ask confirmation when moved
            if (!confirm("Etes vous sûr de vouloir déplacer cet évènement ?")) {
                infos.revert();
            }
        },
        // Log infos when event is streched
        eventResize: (infos) => {
            console.log(infos)
        }
    })

    calendrier.render()
}