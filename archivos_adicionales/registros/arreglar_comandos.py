#!/usr/bin/env python3
import re

def arreglar_comandos_individuales(input_file='REGISTRO_MEJORADO.md', output_file='REGISTRO_MEJORADO.md'):
    """
    Encuentra títulos 'Comando ejecutado: XXX' y mueve el comando a un bloque copiable
    """
    
    with open(input_file, 'r', encoding='utf-8') as f:
        lines = f.readlines()
    
    output_lines = []
    i = 0
    cambios = 0
    
    while i < len(lines):
        line = lines[i]
        
        # Buscar patrón: ## N. Comando ejecutado: COMANDO
        match = re.match(r'^(## \d+\. )Comando ejecutado: (.+)$', line)
        
        if match:
            numero = match.group(1)  # "## N. "
            comando = match.group(2).strip()  # El comando
            
            # Escribir nuevo formato
            output_lines.append(f"{numero}Comando ejecutado\n")
            
            # Copiar la línea de fecha (siguiente línea)
            i += 1
            if i < len(lines):
                output_lines.append(lines[i])  # **📅 Fecha:** ...
            
            # Copiar líneas vacías
            i += 1
            while i < len(lines) and lines[i].strip() == '':
                output_lines.append(lines[i])
                i += 1
            
            # Agregar el comando en bloque copiable
            output_lines.append("\n**📝 Comando:**\n\n")
            output_lines.append("```bash\n")
            output_lines.append(f"{comando}\n")
            output_lines.append("```\n\n")
            
            cambios += 1
            continue
        
        output_lines.append(line)
        i += 1
    
    # Escribir archivo
    with open(output_file, 'w', encoding='utf-8') as f:
        f.writelines(output_lines)
    
    print(f"✅ Archivo procesado: {output_file}")
    print(f"📊 Comandos individuales arreglados: {cambios}")

if __name__ == "__main__":
    arreglar_comandos_individuales()
