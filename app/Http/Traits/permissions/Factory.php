<?php


namespace App\Http\Traits\permissions;


trait Factory
{
    public function scopeCanAddCategory($scope) {
        return $scope->join('factory_permissions','factories.id','=','factory_permissions.id')->value('can_add_category');
    }
    public function scopeCanUpdateCategory($scope) {
        return $scope->join('factory_permissions','factories.id','=','factory_permissions.id')->value('can_update_category');
    }
    public function scopeCanAddProduct($scope) {
        return $scope->join('factory_permissions','factories.id','=','factory_permissions.id')->value('can_add_product');
    }
    public function scopeCanUpdateProduct($scope) {
        return $scope->join('factory_permissions','factories.id','=','factory_permissions.id')->value('can_update_product');
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
