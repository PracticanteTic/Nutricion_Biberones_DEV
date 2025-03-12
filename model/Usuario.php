<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$permisos)
	{

		$sql="INSERT INTO usuario (nombre,tipo_documento,num_documento,direccion,telefono,email,cargo,login,clave,condicion)
		VALUES ('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','1')";
		echo $sql;
		// return ejecutarConsulta($sql);
		$idusuarionew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuarionew', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para editar registros
	public function editar($idusuario,$nombre,$telefono,$email,$cargo,$login,$clave,$permisos)
	{
		$sql1="SELECT clave FROM usuario WHERE idusuario='$idusuario'";
		$select_contrasenia = ejecutarConsulta($sql1);
		if ($select_contrasenia->num_rows > 0) {
			$row = $select_contrasenia->fetch_assoc();
			$clave_bd = $row['clave'];
		
			if ($clave_bd == $clave) {
				$clavea = $clave;
			} else {
				$clavea = hash("SHA256", $clave);
			}
		}
		$sql="UPDATE usuario SET nombre='$nombre',telefono='$telefono',email='$email',cargo='$cargo',login='$login',clave='$clavea' WHERE idusuario='$idusuario'";
		ejecutarConsulta($sql);		

		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel="DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
		ejecutarConsulta($sqldel);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuario', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;

	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)
	{
		$sql="SELECT * FROM usuario WHERE idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM usuario";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los permisos marcados
	public function listarmarcados($idusuario)
	{
		$sql="SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	public function listarRolePermisos($idusuario)
	{
		$sql="SELECT * FROM roles_permiso WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Función para verificar el acceso al sistema
	public function verificar($login,$clave)
    {
    	$sql="SELECT u.idusuario,u.nombre,u.telefono,u.email,u.cargo,u.login, u.clave FROM usuario u 
		WHERE u.login='$login' AND u.clave='$clave' AND u.condicion='1'"; 
    	return ejecutarConsulta($sql);  
    }

	public function googleVerificar($email)
    {
    	$sql="SELECT gu.id_rol, gu.id_usuario_google FROM google_usuarios gu 
		WHERE gu.correo='$email'"; 
    	return ejecutarConsulta($sql);  
    }

	public function GoogleRoleVerificar($cod)
    {
    	$sql="SELECT r.idpermiso FROM roles r 
		WHERE r.id_rol='$cod'"; 
    	return ejecutarConsulta($sql);  
    }

	public function directoryRoleVerificar($cod)
    {
    	$sql="SELECT r.idpermiso FROM roles r 
		WHERE r.cod_directorio='$cod'"; 
    	return ejecutarConsulta($sql);  
    }

	public function directoryVerificar($login)
    {
    	$sql="SELECT u.idusuario FROM usuario u 
		WHERE u.login='$login'"; 
    	return ejecutarConsulta($sql);  
    }

	public function select()
	{
		$sql="SELECT idusuario, concat(nombre,' ',cargo) as nombres  FROM usuario where condicion=1;";
		return ejecutarConsulta($sql);		
	}

}

?>