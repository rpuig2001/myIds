<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<html>
<br />

<tr>
    <form method="post" action="src/metar/searchMetar.php">
        <div class="form-row align-items-center">
            <div class="col-auto">
                <input type="text" name="apt" id="apt" maxlength="4" style="text-transform:uppercase" class="form-control mb-2" id="inlineFormInput" placeholder="Airport ICAO">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-info mb-2">Submit</button>
            </div>
        </div>
    </form>
</tr>
</html>