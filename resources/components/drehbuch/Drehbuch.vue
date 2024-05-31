
<template>

        <form action="/generate-script" method="post">
  <label for="idea">Deine Idee für das Drehbuch:</label><br>
  <textarea id="idea" name="idea" rows="4" cols="50" required></textarea><br><br>
  <input type="submit" value="Weiter">
</form>

<form action="/generate-script" method="post">
  <label for="genre">Genre:</label>
  <select id="genre" name="genre">
    <option value="Drama">Drama</option>
    <option value="Komödie">Komödie</option>
    <option value="Thriller">Thriller</option>
    <!-- Weitere Genre-Optionen -->
  </select><br><br>
  
  <label for="location">Ort:</label>
  <select id="location" name="location">
    <option value="Stadt">Stadt</option>
    <option value="Land">Land</option>
    <option value="Weltraum">Weltraum</option>
    <!-- Weitere Ort-Optionen -->
  </select><br><br>
  
  <label for="time">Zeit:</label>
  <select id="time" name="time">
    <option value="Gegenwart">Gegenwart</option>
    <option value="Vergangenheit">Vergangenheit</option>
    <option value="Zukunft">Zukunft</option>
    <!-- Weitere Zeit-Optionen -->
  </select><br><br>
  
  <label for="main_character">Hauptcharakter:</label><br>
  <input type="text" id="main_character" name="main_character"><br><br>
  
  <label for="mentor">Mentor:</label><br>
  <input type="text" id="mentor" name="mentor"><br><br>
  
  <label for="antagonist">Gegner:</label><br>
  <input type="text" id="antagonist" name="antagonist"><br><br>
  
  <label for="additional_characters">Zusätzliche Charaktere:</label><br>
  <input type="text" id="additional_characters" name="additional_characters"><br><br>
  
  <label for="narrative_perspective">Erzählperspektive:</label>
  <select id="narrative_perspective" name="narrative_perspective">
    <option value="Ich-Perspektive">Ich-Perspektive</option>
    <option value="Erzähler">Erzähler</option>
    <!-- Weitere Erzählperspektiven-Optionen -->
  </select><br><br>
  
  <label for="target_audience">Zielgruppe:</label><br>
  <input type="text" id="target_audience" name="target_audience"><br><br>
  
  <label for="goal">Ziel des Drehbuchs:</label><br>
  <input type="text" id="goal" name="goal"><br><br>
  
  <label for="style">Stil:</label>
  <select id="style" name="style">
    <option value="Düster">Düster</option>
    <option value="Optimistisch">Optimistisch</option>
    <!-- Weitere Stil-Optionen -->
  </select><br><br>
  
  <label for="idea">Idee für das Drehbuch:</label><br>
  <input type="submit" value="Drehbuch generieren">
</form>
</template>
<script setup>

</script>