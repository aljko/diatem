<?php 
    function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    $json = CallAPI('POST', 'localhost:8081');
    

    $aff = json_decode($json,true);

        // On détermine sur quelle page on se trouve
    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }
    //var_dump($aff);
    ?>
    <h1>Liste des villes</h1>
                <table>
                    <thead>
                        <th>Nom</th>
                        <th>Code postal</th>
                        <th>Code INSEE</th>
                        <th>population</th>
                    </thead>
                    <tbody>
                        <?php
                        
                        for($i=$currentPage*10-10; $i<$currentPage*10-1; $i++ ){
                        ?>
                            <tr>
                                <td><?= $aff['result']['villes'][$i]['nom'] ?></td>
                                <td><?= $aff['result']['villes'][$i]['codepostal'] ?></td>
                                <td><?= $aff['result']['villes'][$i]['codeinsee'] ?></td>
                                <td><?= $aff['result']['villes'][$i]['population2010'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

    <nav>
        <ul class="pagination">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                <a href="./?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
            </li>
            <?php for($page = 1; $page <= $pages; $page++): ?>
                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                    <a href="./?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                </li>
            <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                <a href="./?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
            </li>
        </ul>
    </nav>
    
   