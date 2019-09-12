<?php

class Recipe{
    private $id_recipe;
    private $name_recipe;
    private $url_image;
    private $ingredients=array();
    private $preparation;
    public function __construct(){
        $ingredients=array();
	}
    public function addIngredients($ingredient){
        array_push($this->ingredients,$ingredient);
    }

    // gets and sets
    public function getId_recipe() {
        return $this->id_recipe;
    }

    public function setId_recipe($id_recipe) {
        $this->id_recipe = $id_recipe;
    }
    public function getName_recipe() {
        return $this->name_recipe;
    }

    public function getUrl_image() {
        return $this->url_image;
    }

    public function getIngredients() {
        return $this->ingredients;
    }

    public function getPreparation() {
        return $this->preparation;
    }



    public function setName_recipe($name_recipe) {
        $this->name_recipe = $name_recipe;
    }

    public function setUrl_image($url_image) {
        $this->url_image = $url_image;
    }

    public function setIngredients($ingredients) {
        $this->ingredients = $ingredients;
    }

    public function setPreparation($preparation) {
        $this->preparation = $preparation;
    }
}