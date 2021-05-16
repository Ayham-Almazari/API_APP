<?php


namespace App\Http\Traits\permissions;


trait Factory
{
    public function CanAddCategory() {
        return $this->F_permissions->can_add_category;
    }
    public function CanUpdateCategory() {
        return $this->F_permissions->can_update_category;
    }
    public function CanAddProduct() {
        return $this->F_permissions->can_add_product;
    }
    public function CanUpdateProduct() {
        return $this->F_permissions->can_update_product;
    }

    //de-permissive
    public function CanAddCategory_Control($boolean){
        return   $this->F_permissions()->update(["can_add_category" => $boolean]);
    }
    public function canUpdateCategory_Control($boolean){
        return $this->F_permissions()->update(["can_update_category" => $boolean]);
    }
    public function canAddProduct_Control($boolean){
        return $this->F_permissions ->update(["can_add_product" => $boolean]);
    }
    public function canUpdateProduct_Control($boolean){
        return $this->F_permissions->update(["can_update_product" => $boolean]);
    }



}
