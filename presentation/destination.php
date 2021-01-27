<?php
function html($title){ ?>
    <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Mobili'T - <?php echo $title ?></title>
            <meta charset="utf-8">
            <!-- HEAD -->
            <?php include_once '../templates/header.php'?>
            
            <!-- CSS -->
            <link 
                rel="stylesheet" 
                type="text/css" 
                href="../assets/destinations.css">
        </head>
        <body>
<!----------------------------------------------------------------------NAVBAR---------------------------------------------------------------->
<?php include_once '../templates/navbar.php';
}

function footer(){ ?>
<!-- fin de la d.iv class="principale" -->
    </div>
            <?php include '../templates/footer.php';?>
            </footer>
            <?php include_once '../templates/linkScriptJs.php' ?>            
            <script type="text/javascript" src="../assets/scriptDestination.js"></script>
        </body>
    </html>
<?php } ?>


<?php function boutonFrance(){  ?>
        
            <!-- Image de la France -->
            <div id="divContenantFranceMap" class="w-50 mx-auto">
                        <?php   include('../presentation/cmap/carte.html') ?> 
            </div>  
            <div id="contenu_region" class="text-center" ></div>
<?php } ?>


<?php
function affichageDestination($destination, $region, $session)
{ 
    $i=1; ?>

    <div id="<?php echo $region.$i ?>" class="align-items-center m-3">
        <?php foreach($destination as $dest){
            if($dest->getRegion() == $region){ ?>
                <!-- affichage de la destination -->
                <div class="<?php  echo $dest->getRegion().$i ?> row mx-3 mb-4">
                    <div class="">
                        <div class="row">
                            <!-- image  -->
                            <div class="col-12 col-lg-4 mb-2">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode( $dest->getImage() ); ?>" class="img-fluid w-100" alt="Image descriptive de la region"/>
                            </div>
                            <!-- desription + atouts -->
                            <div class="col-12 col-lg-8 text-justify">
                                <!-- titre en majuscule -->
                                <h4 class="mb-3 row ">
                                    <div><?php echo strtoupper($dest->getLieu()) ?></div>
                                </h4>
                                <!-- intro et description -->
                                <p style="text-indent: 20px"><?php echo $dest->getPetiteDescription() ?></p>
                                </br> 
                                <p style="text-indent: 20px" class="font-weight-bold text-break" > <?php echo $dest->getDescription() ?></p>
                                <!-- en lire plus = les atouts -->
                                <div style="display: none;" id="lire_plus_<?=$i ?>">
                                    <div>
                                        <p style="text-indent: 20px" class="text-break"><?php echo $dest->getAtout1() ?></p>
                                        <p  style="text-indent: 20px" class="text-break"><?php echo $dest->getAtout2() ?></p>
                                        <p  style="text-indent: 20px" class="text-break"><?php echo $dest->getAtout3() ?></p>
                                    </div>
                                    <!-- les boutons -->
                                    <div class="row">
                                    <?php 
                                         if(isset($session) && isset($session['id']) && $session['id']==$dest->getIdUser())
                                        {  
                                                    $maj=true;
                                                    buttonAjout($maj, $dest);
                                                ?>
                                            <div class="col-5 m-4">
                                                <a href='../controller/controllerDestination.php?action=suppDestination&amp;id=<?php echo $dest->getIdDestination()?>'>
                                                    <button class='btn btn-outline-danger' value='Remove'>Supprimer</button>
                                                </a>
                                            </div> 
                                        <?php 
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="plus text-right col-12 col-md-8 mb-2">
                            <button class="btn btn-outline-success" id="lp_<?=$i ?>">Lire plus</button>
                        </div>
                        <script>
                            $("#lp_<?=$i ?>").click(function(){

                                if($('#lire_plus_<?=$i ?>').css('display') == 'none')
                                {
                                    $(this).html('Lire moins')
                                    $("#lire_plus_<?=$i ?>").fadeIn()
                                }else{
                                    $(this).html('Lire plus')
                                    $("#lire_plus_<?=$i ?>").fadeOut()
                                }
                            })
                        </script>
                    </div>
                </div>

                <!-- lien forum + lien exploration -->
                <div class="forumLien row col-12">
                    <div class="forum text-center col-12 col-md-10 my-1">
                        <a href ="<?php echo $dest->getExtraitForum() ?>" target="_blank" class="btn btn-outline-success color-228B22">Accéder au Forum</a>
                    </div>
                    <div class="bouton text-center col-12 col-md-2 my-1"> 
                        <a href ="<?php echo $dest->getLien() ?>" target="_blank" class="btn btn-outline-success color-228B22" >M'y rendre</a>
                    </div>
                </div>
                <hr class="my-3">
                <?php $i++;
            // fermeture de la div d'une destination
            echo "</div>";
            }
        }
        //fermeture div de toutes les destinations
    echo "</div>";    
}

function buttonAjout($maj=null, $dest=null)
{ 
    if($maj){$idDestination = $dest->getIdDestination();}?>
     
        <div class="buttonsDestination m-4 "> 
            
            <button id="<?php if(!$maj || $maj==null){echo "AjoutDestination";}elseif($maj){echo "ModifDestination". $idDestination;} ?>" class='<?php if(!$maj || $maj==null){ echo "btn btn-outline-success";}elseif($maj==true){echo "btn btn-outline-danger";}else{}?>'> 
                <?php if(!$maj || $maj==null){ echo "+ Ajouter un article ";}elseif($maj){echo "Modifier l'article";}else{};?>
            </button> 
        </div>
        
        <div id="<?php if(!$maj || $maj==null){ echo "formAjoutDestination";}elseif($maj){echo "formModifDestination". $idDestination;}else{};?>" class="container" style="display:none">
        
        <div class="globalConnexion text-center p-2">
                <form action="../controller/controllerDestination.php?action=<?php if(!$maj || $maj==null){echo "ajoutDestination";}elseif($maj){echo "modifDestination&id=".$idDestination;} ?>" method="POST" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <!-- lieu -->
                                <div class="form-group ">
                                    <label for="<?php if(!$maj){echo "lieuDestination" ;}else{echo "lieuDestination". $idDestination;}?>">Lieu </label>
                                    <input type="text" class="form-control" id="<?php if(!$maj){echo "lieuDestination" ;}else{echo "lieuDestination". $idDestination;}?>" name="lieu" value="<?php if($maj){echo $dest->getLieu() ;}?>" placeholder="Ville ou zone" alt="Saisissez le nom du lieu que vous souhaitez faire découvrir">
                                </div>
                                <!-- Region -->
                                <div class="form-group ">
                                    <label for="<?php if(!$maj){echo "selectRegion" ;}else{echo "selectRegion". $idDestination;}?>">Région</label>
                                    <select class="form-control" id="<?php if(!$maj){echo "selectRegion" ;}else{echo "selectRegion". $idDestination;}?>" name="region">
                                        <option <?php if(!$maj){echo "selected";}elseif($maj){echo "value=".$dest->getRegion();} ?>><?php if(!$maj){echo "Choisir votre région";}elseif($maj){echo $dest->getRegion();}?></option>
                                        <option value="Auvergne-Rhône-Alpes">Auvergne-Rhône-Alpes</option>
                                        <option value="Bourgogne-Franche-Comté">Bourgogne-Franche-Comté</option>
                                        <option value="Bretagne">Bretagne</option>
                                        <option value="Centre">Centre</option>
                                        <option value="Corse">Corse</option>
                                        <option value="Grand-Est">Grand-Est</option>
                                        <option value="Hauts-de-France">Hauts-de-France</option>
                                        <option value="Ile-de-France">Ile-de-France</option>
                                        <option value="Normandie">Normandie</option>
                                        <option value="Nouvelle-Aquitaine">Nouvelle-Aquitaine</option>
                                        <option value="Occitanie">Occitanie</option>
                                        <option value="Pays-de-la-Loire">Pays-de-Loire</option>
                                        <option value="Provence-Alpes-Cote-d-Azur">Provence-Alpes-Côte-d'Azur</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Image -->
                            <div class="col-6 form-group  ">
                                <div class="col-10">
                                    <?php if($maj==true){ ?>
                                         <img id='imageDestinationModif' src='data:image/jpeg;base64,<?php echo base64_encode( $dest->getImage()) ?>' />
                                    <?php } ?>
                                    <label for="image" class="mt-2">Photo</label>
                                    <input type="file" name="image" placeholder="bla" class="form-control img-fluid" id="image" alt="Veillez téléverser une photo illustrant le lieu proposé" accept="image/png, image/jpeg">
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>               
                    
                    <!-- Petite description -->
                    <div class="form-group">
                        <label for="<?php if(!$maj){echo "petiteDescription" ;}else{echo "petiteDescription". $idDestination;}?>">Description introductive</label>
                        <input type="text" class="form-control" name="petiteDescription" minlength="10" maxlength="255" id="<?php if(!$maj){echo "petiteDescription" ;}else{echo "petiteDescription". $idDestination;}?>" value="<?php if($maj){echo $dest->getPetiteDescription() ;}?>" placeholder="Veillez saisir un texte court d'introduction au lieu" alt="Veillez saisir une petite introduction du lieu présenté" >
                    </div>
                    <div class="form-group">
                        <label for="<?php if(!$maj){echo "descriptionDestination";}else{echo "descriptionDestination".$idDestination ;} ?>">Description du lieu</label>
                        <input type="text" class="form-control" name="description" minlength="100" maxlength="500" id="<?php if(!$maj){echo "descriptionDestination";}else{echo "descriptionDestination".$idDestination ;} ?>" value="<?php if($maj){echo $dest->getDescription() ;}?>" placeholder="Veillez décrire plus précisémment le lieu a visiter" alt="Veillez saisir description précise et détaillée du lieu à visiter" required>
                    </div>
                    <div class="form-group">
                        <label for="<?php if(!$maj){echo "atout1Destination" ;}else{echo "atout1Destination". $idDestination;}?>">Premier atout</label>
                        <input type="text" class="form-control" name="atout1" minlength="100" maxlength="300" id="<?php if(!$maj){echo "atout1Destination" ;}else{echo "atout1Destination". $idDestination;}?>" value="<?php if($maj){echo $dest->getAtout1() ;}?>" placeholder="Premier atout du lieu proposé" alt="Présenter le premier atout du lieu proposé en visite" required>
                    </div>
                    <div class="form-group">
                        <label for="<?php if(!$maj){echo "atout2Destination" ;}else{echo "atout2Destination". $idDestination;}?>">Deuxième atout</label>
                        <input type="text" class="form-control" name="atout2" minlength="100" maxlength="300" id="<?php if(!$maj){echo "atout2Destination" ;}else{echo "atout2Destination". $idDestination;}?>" value="<?php if($maj){echo $dest->getAtout2() ;}?>" placeholder="Deuxième atout du lieu proposé" alt="Présenter le deuxième atout du lieu proposé en visite" required>
                    </div>
                    <div class="form-group">
                        <label for="<?php if(!$maj){echo "atout3Destination" ;}else{echo "atout3Destinaton". $idDestination;}?>">Troisième atout</label>
                        <input type="text" class="form-control" name="atout3" minlength="100" maxlength="300" id="<?php if(!$maj){echo "atout3Destination" ;}else{echo "atout3Destination". $idDestination;}?>" value="<?php if($maj){echo $dest->getAtout3() ;}?>" placeholder="Troisième atout du lieu proposé" alt="Présenter le troisième atout du lieu proposé en visite" >
                    </div>
                    <div class="form-group">
                        <label for="<?php if(!$maj){echo "lienSiteWeb" ;}else{echo "lienSiteWeb". $idDestination;}?>">Lien vers un site web </label>
                        <input type="text" class="form-control" name="lien" maxlength="300" id="<?php if(!$maj){echo "lienSiteWeb" ;}else{echo "lienSiteWeb". $idDestination;}?>" value="<?php if($maj){echo $dest->getLien() ;}?>" placeholder="ex : www.handitourisme-champagne.org" alt="Veuillez saisir un lien pour accéder à plus d'informations pour cette destination">
                    </div>
                    <div class="form-group">
                        <label for="<?php if(!$maj){echo "extraitForum" ;}else{echo "extraitForum". $idDestination;}?>">Lien vers un extrait du forum </label>
                        <input type="text" class="form-control" name="extraitForum" maxlength="300" id="<?php if(!$maj){echo "extraitForum" ;}else{echo "extraitForum". $idDestination;}?>" value="<?php if($maj){echo $dest->getExtraitForum() ;}?>" placeholder="ex : www.handitourisme-champagne.org" alt="Veuillez saisir un lien pour accéder à un sujet du forum pertinent">
                    </div>
                    <input type="submit" class="btn btn-primary" style="background-color: #228b22;border: black;" value="<?php if(!$maj || $maj==null){ echo 'Ajouter ';}elseif($maj){echo 'Modifier ';}else{};?>"></input>
                </form>
            </div>
        </div>
    
<?php } ?>
