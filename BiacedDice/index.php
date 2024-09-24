<!DOCTYPE HTML>
<HTML>
    <HEADL>
        <link rel="stylesheet" href="styles.css">
        <title>Biased Dice Roller</title>
    </HEADL>
    <BODY>
        <h1>Biased Dice Roller </h1>
        <form method="post" action="">
            <input type="hidden" name="roll" value="1">
            <button type="submit">Roll Dice</button>
            <button type="reset">Reset</button>
        </form>
    <?PHP
    if (isset($_POST['roll'])) {
    $DiceRoll = rand(1,6);
    echo "<p> you have rolled a: $DiceRoll </p>";
    }
    ?>
    </BODY>
</HTML>