# Hybrid mapping driver
Library that allows developers to intermix annotation and attributes based entity metadata.

## what is this?
PHP (as of verion 8 and higher) allows to use attributes feature to embed code metadata. Similarly Doctrine of version 2.9.3 allow us to utilize Attributes to store entity metadata instead of using docblock annotations as was the status quo until the attributes came.

But in large projects there is often a lot of entities and the way Doctrine works out of the box is to choose between annotations and attributes and have metadata of _all_ entities encoded the same way. This is often undesirable as bulk changing all annotations is risky and regression tests are time-expensive.

This is a small library aims to allow hybrid approach - to allow intermixing the two ways to store the metadata. It's purpose is not to conserve the old-school way forever, but to allow updating it in steps as small as anyone needs.

There is a `neon` config file included in this project to show how to register the driver (in `nette` appliaction). Also there is `NullCache` and `EntityManagerFactory` included to make this library more standalone as well as en example on how to utilize it.
