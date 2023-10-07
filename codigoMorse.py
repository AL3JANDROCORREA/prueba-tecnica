# Diccionario de código Morse
MORSE_CODE = {
    "a": ".-",
    "b": "-...",
    "c": "-.-.",
    "d": "-..",
    "e": ".",
    "f": "..-.",
    "g": "--.",
    "h": "....",
    "i": "..",
    "j": ".---",
    "k": "-.-",
    "l": ".-..",
    "m": "--",
    "n": "-.",
    "o": "---",
    "p": ".--.",
    "q": "--.-",
    "r": ".-.",
    "s": "...",
    "t": "-",
    "u": "..-",
    "v": "...-",
    "w": ".--",
    "x": "-..-",
    "y": "-.--",
    "z": "--..",
    "1": ".----",
    "2": "..---",
    "3": "...--",
    "4": "....-",
    "5": ".....",
    "6": "-....",
    "7": "--...",
    "8": "---..",
    "9": "----.",
    "0": "-----",
    " ": "/",
}

# Función para traducir de código Morse a texto
def morse_to_text(morse_code):
    """
    Traduce un mensaje de código Morse a texto.

    Args:
        morse_code: El mensaje de código Morse a traducir.

    Returns:
        El mensaje traducido a texto.
    """

    # Separamos el mensaje en palabras
    words = morse_code.split(" ")

    # Traducimos cada palabra
    text = ""
    for word in words:
        letters = word.split("/")
        for letter in letters:
            for char, code in MORSE_CODE.items():
                if letter == code:
                    text += char
                    break
            else:
                # Si no se encontró una letra correspondiente, se agrega un espacio
                text += " "
        text += " "  # Agregamos un espacio entre palabras
        

    return text


# Función para traducir de texto a código Morse
def text_to_morse(text):
    """
    Traduce un mensaje de texto a código Morse.

    Args:
        text: El mensaje de texto a traducir.

    Returns:
        El mensaje traducido a código Morse.
    """

    # Convertimos el texto a mayúsculas
    text = text.lower()

    # Convertimos cada letra a código Morse
    morse_code = ""
    for char in text:
        if char == " ":
            morse_code += " "  # Representación de espacio en código Morse
        else:
            morse_code += MORSE_CODE.get(char, "")

    return morse_code

# Función para determinar la dirección de traducción
def translate():
    while True:
        choice = input("Elija una opción (1 para texto a código Morse, 2 para código Morse a texto, q para salir): ")
        if choice == "1":
            text_input = input("Ingrese el texto a traducir a código Morse: ")
            morse_result = text_to_morse(text_input)
            print("Texto traducido a código Morse:", morse_result)
        elif choice == "2":
            morse_input = input("Ingrese el código Morse a traducir a texto con espacios: ")
            text_result = morse_to_text(morse_input)
            print("Código Morse traducido a texto:", text_result)
        elif choice == "q":
            break
        else:
            print("Opción no válida. Intente de nuevo.")

    # Comprobamos si el usuario ingresó un mensaje de texto todo junto sin espacios

    if choice == "2" and morse_input.strip() == morse_input:
        # Convertimos el mensaje a un diccionario
        morse_input = morse_input.strip().split("")
        letters = {}
        for letter in morse_input:
            for char, code in MORSE_CODE.items():
                if letter == code:
                    letters[char] = letter
                    break

        # Traducimos el mensaje
        text_result = ""
        for letter in letters:
            text_result += letter

        # Imprimimos el resultado
        print("Código Morse traducido a texto:", text_result)


# Ejecutar el programa
if __name__ == "__main__":
    translate()
