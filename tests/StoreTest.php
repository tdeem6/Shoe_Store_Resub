<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';

	$DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function test_getName()
        {
            $name = "Nike Outlet";
            $test_store = new Store($name);

            $result = $test_store->getName();

            $this->assertEquals($name, $result);
        }

       function test_setName()
        {
            $name = "Nike Outlet";
            $test_store = new Store($name, $id);

            $test_store->setName("Nike Outlet");

            $result = $test_store->getName();

            $this->assertEquals("Nike Outlet", $result);
        }

        function test_updateName()
        {
            $name = "Nike Outlet";
            $test_store = new Store($name, $id);
            $test_store->save();

            $new_name = "Journeys";

            $test_store->updateName($new_name);

            $this->assertEquals("Journeys", $test_store->getName());
        }

        function test_getId()
        {
            $name = "Nike Outlet";
            $id = 1;
            $test_store = new Store($name, $id);

            $result = $test_store->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            $name = "Nike Outlet";
            $test_store = new Store($name, $id);
            $test_store->save();

            $result = Store::getAll();

            $this->assertEquals($test_store, $result[0]);
        }

        function test_delete()
        {
            $name = "Nike Outlet";
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Journeys";
            $test_store2 = new Store($name2, $id);
            $test_store2->save();

            $test_store->delete();

            $this->assertEquals([$test_store2], Store::getAll());
        }

        function test_getAll()
        {
            $name = "Nike Outlet";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Journeys";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store2, $test_store], $result);
        }

        function test_deleteAll()
        {
            $name = "Nike Outlet";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Journeys";
            $test_store2 = new Store($name2);
            $test_store2->save();

            Store::deleteAll();
            $result = Store::getAll();

            $this->assertEquals([], $result);
        }

        function test_find()
        {
            $name = "Nike Outlet";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Journeys";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $result = Store::find($test_store->getId());

            $this->assertEquals($test_store, $result);
        }

        function test_addBrand()
        {
            $name = "Nike Outlet";
            $test_store = new Store($name, $id);
            $test_store->save();

            $name = "Nike";
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $test_store->addBrand($test_brand->getId());

            $this->assertEquals($test_store->getBrands(), [$test_brand]);
        }

        function test_getBrands()
        {
            $name = "Nike";
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Puma";
            $test_brand2 = new Brand($name2, $id);
            $test_brand2->save();

            $name = "Nike Outlet";
            $test_store = new Store($name, $id);
            $test_store->save();

            $test_store->addBrand($test_brand->getId());
            $test_store->addBrand($test_brand2->getId());

            $this->assertEquals($test_store->getBrands(), [$test_brand2, $test_brand]);
        }

        function test_deleteBrand()
        {
            $name = "Nike Outlet";
            $test_store = new Store($name, $id);
            $test_store->save();

            $brand_name = "Nike";
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();

            $brand_name2 = "Puma";
            $test_brand2 = new Brand($brand_name2, $id);
            $test_brand2->save();

            $test_store->addBrand($test_brand->getId());
            $test_store->addBrand($test_brand2->getId());

            $test_store->deleteBrand($test_brand->getId());
            $result = $test_store->getBrands();

            $this->assertEquals([$test_brand2], $result);
        }

        function test_deleteAllbrands()
        {
            $name = "Nike Outlet";
            $test_store = new Store($name, $id);
            $test_store->save();

            $name = "Nike";
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Puma";
            $test_brand2 = new Brand($name2, $id);
            $test_brand2->save();

            $test_store->addBrand($test_brand->getId());
            $test_store->addBrand($test_brand2->getId());

            $test_store->deleteAllBrands();
            $result = $test_store->getBrands();

            $this->assertEquals([], $result);
        }

    }
?>
