<?php $this->titre = "Meilleurs Scores";?>

<section class="instructions-scores">
    <h2 class="reglement">PODIUM</h2>
    <table>
        <thead>
            <tr>
                <th>PSEUDO</th>
                <th>SCORE</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?=htmlspecialchars($user['pseudo'])?></td>
                <td><?=$user['snakeScore']?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

</section>
