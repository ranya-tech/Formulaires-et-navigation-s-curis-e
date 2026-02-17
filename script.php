<form method="post">
    <select name="filter">
        <option value="toutes">Toutes</option>
        <option value="a-faire">À faire</option>
        <option value="fait">Fait</option>
    </select>
    <button type="submit" name='btn'>Filtrer</button>
</form>
<?php
$json = file_get_contents('data.json');
$taches = json_decode($json, true);
if($_SERVER['REQUEST_METHOD']==="POST"){
    $tacheId = $_POST['TacheId'] ?? null;
    if(isset($_POST['supprimer'])){
        foreach($taches as $id => $tache){
            if($tache['id'] == $tacheId){
                unset($taches[$id]);
            }
        }
        $taches =  array_values($taches);
        file_put_contents('data.json', json_encode($taches, JSON_PRETTY_PRINT));
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
    if(isset($_POST['change'])){
        foreach($taches as &$tache){
            if($tache['id'] == $tacheId){
                if($tache['etat'] == 'a-faire'){
                    $tache['etat'] = 'fait';
                }else{
                    $tache['etat'] = 'a-faire';
                }
            }
        }
        file_put_contents('data.json', json_encode($taches, JSON_PRETTY_PRINT));
        header("Location: ". $_SERVER['PHP_SELF']);
        exit;    
    }
    if(isset($_POST['btn'])){
        $choix = $_POST['filter'];
        if($choix !== "toutes"){
            $taches = array_filter($taches, fn($t) => $t['etat'] === $choix);
        }
    }
}
$table = "<h3>Tableau de tâches:</h3>
        <table border='1'>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>État</th>
                <th>Actions</th>
            </tr>";
foreach($taches as $tache){
    $table.= "<tr>
               <form method='POST'>
                <td><input type='hidden' name='TacheId' value='".$tache['id']."'>".$tache['id']."</td>
                <td>".$tache['titre']."</td>
                <td>".$tache['etat']."</td>
                <td><button name='supprimer'>Supprimer</button><button name='change'>Changer l’état</button></td>
               </form>
            </tr>";
}
$table.= "</table>";
echo $table."<br>";
?>
<form method="post">
    <input type="text" name="" palceholder="">
    <button type="submit">Ajouter</button>
</form>