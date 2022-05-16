function moveToSearch() {
    document.getElementById("form-container").scrollIntoView({behavior: 'smooth', block: 'nearest'});
}

function stringDate(date) { // function creates a "string" version of the date object passed onto it
    
    let day = date.getDate();
    if (day < 10) {
        day = "0" + day;
    }
    let month = date.getMonth() + 1;
    if (month < 10) {
        month = "0" + month;
    }
    let year = date.getFullYear();

    return day + "/" + month + "/" + year;

}

function createHTML(newArray){

    let arrayLen = newArray.length;
    let insertHTML = "";

    for (let i = 0; i < arrayLen; i++){

        let imgName = newArray[i].name.replace(/\s/g,'').toLowerCase() + ".jpg"; // image file name based on venue name

        insertHTML += "<div class='result-card'>" +
        "<img src='" + imgName + "' alt='venueimg' class='result-image'>" + "<h1>" + newArray[i].name + "</h1>" + "<h3> Capacity: " + newArray[i].capacity + "</h3>" + "<hr>" +
        "<div class='result-info'>" + 
        "<h4> Booked?: " + "<br>" + newArray[i].isBooked + "</h4>" + 
        "<h4> Licensed: " + "<br>" + newArray[i].Licensed + "</h4>" + 
        "<h4> Total bookings: " + "<br>" + newArray[i].numBookings + "</h4>" +
        "<h4> Cost per person: " + "<br>" + newArray[i].PersonCost + "</h4>" +
        "<hr>" +
        "<h4> Day price: " + "<br>" + newArray[i].DayCost + "</h4>" +
        "<h4> Total price: " + "<br>" + newArray[i].TotalCost + "</h4>" +
        "</div>" + "</div>";
    }

    $("#insertVenues").html(insertHTML); // insert above HTML string into the desired results div
}

function submitForm(){
    $("form").submit(function(event){
        event.preventDefault();

        let bookingDate = $("#inputDate").val(); // values of inputs from form
        let partySize = $("#partySize").val();
        let cateringGrade = $("#cateringGrade").val();
        

        let dateFormat = new Date(bookingDate); // transform booking date from string to date object
        let chosenDay = dateFormat.toLocaleString('en-us', {  weekday: 'long' }); // extract day of the week from date object and transform it into long string
        let dateString = stringDate(dateFormat);

        $.ajax({
            url: "weddingform.php",
            type: "POST",
            data: {bookingDate:bookingDate, partySize:partySize, cateringGrade:cateringGrade},
            success: function(responseData){    
                if ($("#insertVenues").children().length > 0){ // checking if the div(s) has any HTML elements inside, to remove old/unnecessary ones.
                    $("#insertVenues").empty();
                    $("#insertDay").empty();
                }

                let newArray = []; // array will store combined SQL query results
                let i = responseData.length - 1; // will be used to loop from the end of the array; index of the last element in responseData

                if (responseData.length == 0){ // check if there are no available results
                    $("#insertVenues").html("<h1> No results available. Please change search criteria </h1>");
                    return false;
                }

                while  (Object.keys(responseData[i]).length == 4){ // Checks if the chosen JSON object is from SQL #3 query (has 4 different key-value pairs)

                    let tempObj = new Object(); // temporary Object that will contain the merged results of 3 SQL queries
                    let name = responseData[i].name;

                    for (let k = 0; k < responseData.length; k++){ // go backwards because the most important results are at the end
                        if (name == responseData[k].name){
                            Object.assign(tempObj, responseData[k]); // merges Objects if finds that names match
                        }
                    }
                    
                    newArray.push(tempObj); // after all Object merge, push them to new array
                    i--;
                }

                let insertDateHTML = "<h3> Booking date chosen: " + chosenDay + ", " + dateString + " </h3>";
                $("#insertDay").html(insertDateHTML); // display string version of chosen date

                if (newArray.length == 0){ // check if there are no available results
                    $("#insertVenues").html("<h1> No results available. Please change search criteria </h1>");
                }
                else { // create the HTML tags to display the results and then scroll user into view of them
                    createHTML(newArray);
                    document.getElementById("results-container").scrollIntoView({behavior: 'smooth'});
                }
            },
            error: function(xhr, status, error){
                console.log("Error! " + xhr.status + ": " + xhr.statusText + " " + error);
                // do sth else if error
            },
            dataType: "json"
        });
        });
    }