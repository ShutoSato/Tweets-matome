import oseti
import ipadic

analyzer = oseti.Analyzer('-r /app/.heroku/python/lib/python3.6/site-packages/ipadic/dicdir/mecabrc')
analyzer.analyze('天国で待ってる。')