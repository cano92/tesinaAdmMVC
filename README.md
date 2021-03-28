# TesinaAdmMVC
Proyecto ABM de tesinas y Usuarios con Administración de Roles y Permisos para cada
usuario

TesinaAdmMVC lleva el seguimiento de usuarios con rol de **Alumnos** para poder presentar una tesis atravez de los distintos estados hasta concluir los mismos y llevar un seguimiento de parte de otros usuarios con rol de **personal administrativo** quienes se encargan de guiar a los alumnos, aceptar nuevas solicitudes y calificar las distintas tesis presentadas 

Diagrama UML
![Screenshot](tesinaAdmMVC-UML.png)

Descripcion de Roles y Persmisos


##### administrador 
> * all
				

##### personal administrativo
> * usuario_accept
> * tesina_finish
> * tesina_show
> * usuario_update			
> * usuario_show		

##### alumno	
> * tesina_new
> * tesina_update
> * tesina_finish
> * tesinas_Show
> * usuario_update
> * usuario_show				

##### invitado
> * usuario_update
> * usuario_show	

Los usuarios Admin pueden pueden agregar mas roles y mas permisos y asignar roles a nuevos usuarios

