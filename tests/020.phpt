--TEST--
FFI 020: read-only
--SKIPIF--
<?php require_once('skipif.inc'); ?>
--FILE--
<?php
try {
	$p = FFI::new("struct {int x; const int y;}");
	$p->x = 1;
	$p->y = 1;
	echo "ok\n";
} catch (Throwable $e) {
	echo get_class($e) . ": " . $e->getMessage()."\n";
}
try {
	$p = FFI::new("struct {const int x; int y;}");
	$p->y = 1;
	$p->x = 1;
	echo "ok\n";
} catch (Throwable $e) {
	echo get_class($e) . ": " . $e->getMessage()."\n";
}
try {
	$p = FFI::new("const struct {int x; int y;}");
	$p->x = 1;
	echo "ok\n";
} catch (Throwable $e) {
	echo get_class($e) . ": " . $e->getMessage()."\n";
}
try {
	$p = FFI::new("const int[10]");
	$p[1] = 1;
	echo "ok\n";
} catch (Throwable $e) {
	echo get_class($e) . ": " . $e->getMessage()."\n";
}
try {
	$p = FFI::new("const int * [1]");
	$p[0] = null;
	echo "ok\n";
} catch (Throwable $e) {
	echo get_class($e) . ": " . $e->getMessage()."\n";
}
try {
	$p = FFI::new("int * const [1]");
	$p[0] = null;
	echo "ok\n";
} catch (Throwable $e) {
	echo get_class($e) . ": " . $e->getMessage()."\n";
}
try {
	$f = new FFI("typedef int * const t[1];");
	$p = $f->new("t");
	$p[0] = null;
	echo "ok\n";
} catch (Throwable $e) {
	echo get_class($e) . ": " . $e->getMessage()."\n";
}
?>
ok
--EXPECTF--
FFIException: Attempt to assign read-only field 'y'
FFIException: Attempt to assign read-only field 'x'
FFIException: Attempt to assign read-only location
FFIException: Attempt to assign read-only location
ok
FFIException: Attempt to assign read-only location
FFIException: Attempt to assign read-only location
ok
