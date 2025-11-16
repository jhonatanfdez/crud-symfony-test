#!/usr/bin/env python3
import re

def detectar_tipo_codigo(linea):
    """Detecta qué tipo de código es la línea"""
    linea = linea.strip()
    
    # Comandos de terminal
    if any(linea.startswith(cmd) for cmd in ['git ', 'php ', 'symfony ', 'composer ', 'npm ', 'yarn ', 'docker ', 'mysql ', 'cd ', 'mkdir', 'chmod', 'ls ', 'cat ', 'echo ']):
        return 'bash'
    
    # Código PHP
    if '<?php' in linea or linea.startswith('namespace ') or linea.startswith('use ') or linea.startswith('class ') or '->' in linea or '::' in linea:
        return 'php'
    
    # Código Twig
    if '{% ' in linea or '{{ ' in linea or '{# ' in linea:
        return 'twig'
    
    # SQL
    if any(linea.upper().startswith(sql) for sql in ['SELECT ', 'INSERT ', 'UPDATE ', 'DELETE ', 'CREATE ', 'ALTER ', 'DROP ']):
        return 'sql'
    
    return None

def convertir_entrada_a_markdown(entrada, numero):
    """Convierte una entrada individual a formato Markdown"""
    lines = []
    
    # Extraer fecha y título
    date_match = re.search(r'\[([^\]]+)\] (.+?)(?:\n|$)', entrada)
    if not date_match:
        return None
    
    fecha = date_match.group(1)
    titulo = date_match.group(2)
    
    # Crear anchor
    anchor = re.sub(r'[^a-z0-9\s-]', '', titulo.lower())
    anchor = re.sub(r'\s+', '-', anchor)
    
    # Header
    lines.append(f"<a id='{numero}-{anchor}'></a>\n")
    lines.append(f"## {numero}. {titulo}\n")
    lines.append(f"**📅 Fecha:** {fecha}\n\n")
    
    # Procesar contenido
    contenido = entrada.split('\n', 1)[1] if '\n' in entrada else ''
    lineas_contenido = contenido.split('\n')
    
    bloque_codigo = []
    tipo_bloque = None
    en_lista_comandos = False
    
    for linea in lineas_contenido:
        linea_strip = linea.strip()
        
        # Detectar inicio de lista de comandos
        if linea_strip.startswith('Comandos:') or linea_strip.startswith('Comando:'):
            # Cerrar bloque anterior si existe
            if bloque_codigo and tipo_bloque:
                lines.append(f"```{tipo_bloque}\n")
                lines.append(''.join(bloque_codigo))
                lines.append("```\n\n")
                bloque_codigo = []
                tipo_bloque = None
            
            lines.append(f"**📝 {linea_strip}**\n\n")
            en_lista_comandos = True
            continue
        
        # Detectar fin de lista de comandos
        if en_lista_comandos and (linea_strip.startswith('¿') or linea_strip.startswith('Resultado:') or linea_strip.startswith('ANTES:') or linea_strip.startswith('DESPUÉS:')):
            # Cerrar bloque de comandos
            if bloque_codigo and tipo_bloque:
                lines.append(f"```{tipo_bloque}\n")
                lines.append(''.join(bloque_codigo))
                lines.append("```\n\n")
                bloque_codigo = []
                tipo_bloque = None
            en_lista_comandos = False
            lines.append(f"**{linea_strip}**\n\n")
            continue
        
        # Procesar comandos numerados
        if en_lista_comandos:
            numero_match = re.match(r'^(\d+)\.\s+(.+)$', linea_strip)
            if numero_match:
                comando = numero_match.group(2)
                tipo_actual = detectar_tipo_codigo(comando)
                
                if tipo_actual:
                    # Si cambia el tipo de código, cerrar bloque anterior
                    if tipo_bloque and tipo_bloque != tipo_actual:
                        lines.append(f"```{tipo_bloque}\n")
                        lines.append(''.join(bloque_codigo))
                        lines.append("```\n\n")
                        bloque_codigo = []
                    
                    tipo_bloque = tipo_actual
                    bloque_codigo.append(comando + '\n')
                else:
                    # Cerrar bloque si no es código
                    if bloque_codigo and tipo_bloque:
                        lines.append(f"```{tipo_bloque}\n")
                        lines.append(''.join(bloque_codigo))
                        lines.append("```\n\n")
                        bloque_codigo = []
                        tipo_bloque = None
                    lines.append(f"{linea}\n")
            elif linea_strip:
                # Línea no numerada en lista de comandos
                tipo_actual = detectar_tipo_codigo(linea_strip)
                if tipo_actual:
                    if tipo_bloque and tipo_bloque != tipo_actual:
                        lines.append(f"```{tipo_bloque}\n")
                        lines.append(''.join(bloque_codigo))
                        lines.append("```\n\n")
                        bloque_codigo = []
                    tipo_bloque = tipo_actual
                    bloque_codigo.append(linea_strip + '\n')
                else:
                    if bloque_codigo and tipo_bloque:
                        lines.append(f"```{tipo_bloque}\n")
                        lines.append(''.join(bloque_codigo))
                        lines.append("```\n\n")
                        bloque_codigo = []
                        tipo_bloque = None
                    lines.append(f"{linea}\n")
            else:
                lines.append("\n")
        else:
            # Fuera de lista de comandos, procesar normalmente
            if linea_strip:
                lines.append(f"{linea}\n")
            else:
                lines.append("\n")
    
    # Cerrar último bloque si existe
    if bloque_codigo and tipo_bloque:
        lines.append(f"```{tipo_bloque}\n")
        lines.append(''.join(bloque_codigo))
        lines.append("```\n\n")
    
    lines.append("---\n\n")
    
    return ''.join(lines)

def convertir_version_nueva_a_markdown(version_text, numero):
    """Convierte una versión nueva (VERSIÓN vX.Y.Z) a formato Markdown"""
    lines = []
    
    # Extraer versión y título
    version_match = re.search(r'VERSIÓN (v[\d.]+) - (.+?)(?:\n|$)', version_text)
    if not version_match:
        return None
    
    version = version_match.group(1)
    titulo = version_match.group(2).strip()
    
    # Extraer fecha
    fecha_match = re.search(r'Fecha:\s*(.+?)(?:\n|$)', version_text)
    fecha = fecha_match.group(1).strip() if fecha_match else "Fecha no especificada"
    
    # Crear anchor
    titulo_completo = f"{version} - {titulo}"
    anchor = re.sub(r'[^a-z0-9\s-]', '', titulo_completo.lower())
    anchor = re.sub(r'\s+', '-', anchor)
    
    # Header
    lines.append(f"<a id='{numero}-{anchor}'></a>\n")
    lines.append(f"## {numero}. {titulo_completo}\n")
    lines.append(f"**📅 Fecha:** {fecha}\n\n")
    
    # Procesar contenido (después de la fecha)
    contenido_lines = version_text.split('\n')
    skip_until_content = True
    
    for linea in contenido_lines:
        linea_strip = linea.strip()
        
        # Saltar header y separadores iniciales
        if skip_until_content:
            if linea_strip.startswith('OBJETIVO:') or linea_strip.startswith('CAMBIOS'):
                skip_until_content = False
            else:
                continue
        
        # Ignorar líneas de separadores ===
        if linea_strip.startswith('==='):
            continue
        
        # Convertir secciones especiales a headers
        if linea_strip.startswith('OBJETIVO:'):
            lines.append(f"### 🎯 Objetivo\n\n")
        elif linea_strip.startswith('CAMBIOS REALIZADOS:'):
            lines.append(f"### 📝 Cambios Realizados\n\n")
        elif linea_strip.startswith('ARCHIVOS MODIFICADOS:'):
            lines.append(f"### 📂 Archivos Modificados\n\n")
        elif linea_strip.startswith('COMMIT:'):
            commit_hash = linea_strip.replace('COMMIT:', '').strip()
            lines.append(f"**Commit:** `{commit_hash}`\n\n")
        elif linea_strip.startswith('TAG:'):
            tag = linea_strip.replace('TAG:', '').strip()
            lines.append(f"**Tag:** `{tag}`\n\n")
        elif linea_strip.startswith('PUSH:'):
            push_info = linea_strip.replace('PUSH:', '').strip()
            lines.append(f"**Push:** {push_info}\n\n")
        elif linea_strip.startswith('LÍNEAS AÑADIDAS:'):
            stats = linea_strip.replace('LÍNEAS AÑADIDAS:', '').strip()
            lines.append(f"**Estadísticas:** {stats}\n\n")
        elif linea_strip:
            lines.append(f"{linea}\n")
        else:
            lines.append("\n")
    
    lines.append("---\n\n")
    
    return ''.join(lines)

def procesar_primeras_n_entradas(n=20, input_file='registro_backup.txt', output_file='REGISTRO_MEJORADO.md'):
    """Procesa solo las primeras N entradas para verificar"""
    
    with open(input_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Extraer entradas del formato antiguo [DD/MM/YYYY ...]
    sections = content.split('---')
    entries_antiguas = []
    for section in sections:
        section = section.strip()
        if re.search(r'\[\d{2}/\d{2}/\d{4} \d{2}:\d{2}:\d{2} [ap]\.m\.\]', section):
            entries_antiguas.append(('antigua', section))
    
    # Extraer versiones nuevas (VERSIÓN vX.Y.Z)
    versiones_nuevas = []
    patron_version = r'(VERSIÓN v[\d.]+.*?(?=VERSIÓN v[\d.]|$))'
    matches = re.finditer(patron_version, content, re.DOTALL)
    for match in matches:
        version_content = match.group(1).strip()
        # Filtrar solo las que tienen "Fecha:"
        if 'Fecha:' in version_content:
            versiones_nuevas.append(('nueva', version_content))
    
    # Combinar todas las entradas
    all_entries = entries_antiguas + versiones_nuevas
    
    print(f"📊 Entradas formato antiguo [DD/MM/YYYY]: {len(entries_antiguas)}")
    print(f"📊 Versiones formato nuevo (VERSIÓN vX.Y.Z): {len(versiones_nuevas)}")
    print(f"📊 Total: {len(all_entries)}")
    print(f"🔄 Procesando las primeras {n} entradas...\n")
    
    # Crear archivo Markdown
    with open(output_file, 'w', encoding='utf-8') as f:
        # Header
        f.write("# 📚 Registro de Actividades - CRUD Symfony\n\n")
        f.write("Documentación completa del desarrollo del proyecto CRUD Symfony.\n\n")
        f.write("**Versiones:** v1.0.0 → v1.25.0\n\n")
        f.write("**Fecha:** 12-13 de noviembre de 2025\n\n")
        f.write(f"**Entradas procesadas:** {min(n, len(all_entries))}/{len(all_entries)}\n\n")
        f.write("---\n\n")
        f.write("## 📋 Índice\n\n")
        
        # Índice
        for idx in range(min(n, len(all_entries))):
            tipo, entry = all_entries[idx]
            
            if tipo == 'antigua':
                date_match = re.search(r'\[([^\]]+)\] (.+?)(?:\n|$)', entry)
                if date_match:
                    titulo = date_match.group(2)
            else:  # nueva
                version_match = re.search(r'VERSIÓN (v[\d.]+) - (.+?)(?:\n|Fecha:)', entry)
                if version_match:
                    titulo = f"{version_match.group(1)} - {version_match.group(2)}"
                else:
                    titulo = "Versión sin título"
            
            anchor = re.sub(r'[^a-z0-9\s-]', '', titulo.lower())
            anchor = re.sub(r'\s+', '-', anchor)
            f.write(f"{idx + 1}. [{titulo}](#{idx + 1}-{anchor})\n")
        
        f.write("\n---\n\n")
        
        # Procesar entradas
        for idx in range(min(n, len(all_entries))):
            tipo, entry = all_entries[idx]
            
            print(f"  ✅ Procesando entrada {idx + 1}/{min(n, len(all_entries))} ({tipo}): ", end='')
            
            if tipo == 'antigua':
                date_match = re.search(r'\[([^\]]+)\] (.+?)(?:\n|$)', entry)
                if date_match:
                    print(date_match.group(2)[:50] + '...')
                md_entry = convertir_entrada_a_markdown(entry, idx + 1)
            else:  # nueva
                version_match = re.search(r'VERSIÓN (v[\d.]+) - (.+?)(?:\n|Fecha:)', entry)
                if version_match:
                    print(f"{version_match.group(1)} - {version_match.group(2)[:40]}...")
                md_entry = convertir_version_nueva_a_markdown(entry, idx + 1)
            
            if md_entry:
                f.write(md_entry)
    
    print(f"\n✅ Archivo creado: {output_file}")
    print(f"📊 Entradas procesadas: {min(n, len(all_entries))}/{len(all_entries)}")

if __name__ == "__main__":
    procesar_primeras_n_entradas(100)  # Procesar TODAS (68 + ~10 versiones nuevas)
