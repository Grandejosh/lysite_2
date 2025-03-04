import sys
import os
from dotenv import load_dotenv
load_dotenv()
sys.path.insert(0, '/var/www/html/'+os.getenv("PROJECT_PATH")+'/asistente_lyon')

from OPENAI_Lyon import app as application #OPENAI_Lyon.py es sin el py nada mas del archivo requerido
