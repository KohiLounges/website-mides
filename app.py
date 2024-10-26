from flask import Flask, request, render_template, jsonify
import mysql.connector
from mysql.connector import Error

app = Flask(__name__)

# Conexión a la base de datos MySQL (ajusta los parámetros según tu configuración)
def create_connection():
    connection = None
    try:
        connection = mysql.connector.connect(
            host="localhost",
            user="root",  # Cambia esto si tu usuario de MySQL es diferente
            password="",  # Pon tu contraseña de MySQL aquí
            database="midesgames"  # Nombre de tu base de datos
        )
        print("Conexión a MySQL exitosa")
    except Error as e:
        print(f"Error al conectar a MySQL: {e}")
    return connection

@app.route('/')  # Ruta principal
def index():
    return render_template('index.html')  # Renderiza el archivo index.html

@app.route('/register', methods=['POST'])
def register():
    username = request.form['username']
    password = request.form['password']
    
    # Conectar a la base de datos y registrar al usuario
    conn = create_connection()
    cursor = conn.cursor()
    cursor.execute("INSERT INTO users (username, password) VALUES (%s, %s)", (username, password))
    conn.commit()
    
    # Cerrar conexión
    cursor.close()
    conn.close()
    
    # Redirigir a la página de éxito
    return render_template('success.html')

@app.route('/success')
def success():
    return render_template('success.html')

if __name__ == '__main__':
    app.run(debug=True, port=5001)  # Cambia el puerto si es necesario
