import oseti
import ipadic

analyzer = oseti.Analyzer('mecab_args=ipadic.MECAB_ARGS -r /app/.heroku/python/lib/python3.6/site-packages/ipadic/dicdir/mecabrc')
analyzer.analyze('天国で待ってる。')