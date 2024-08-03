
# Weather Info Theme for WordPress

## Descrição
Este é um tema WordPress personalizado que integra informações climáticas utilizando a API da OpenWeatherMap. O tema foi desenvolvido com SASS e Bootstrap para proporcionar uma estética moderna e responsiva.

## Requisitos
- WordPress
- Node.js
- npm ou Yarn
- API Key do OpenWeatherMap
- Plugin [Weather-Info-for-WordPress](https://github.com/luizreimann/Weather-Info-for-WordPress)

## Instalação

1. **Clone o repositório do tema:**
   ```bash
   git clone https://github.com/seu-usuario/seu-repositorio.git
   ```

2. **Clone o repositório do plugin:**
   ```bash
   git clone https://github.com/luizreimann/Weather-Info-Theme-for-WordPress.git
   ```

3. **Instale as dependências do tema:**
   ```bash
   cd seu-repositorio
   npm install
   ```

4. **Compile os arquivos SASS:**
   ```bash
   npm run build-css
   ```

5. **Ative o tema e o plugin:**
   - No WordPress Admin, vá para **Aparência > Temas** e ative o tema **Weather Info Theme**.
   - Vá para **Plugins > Adicionar Novo > Fazer Upload de Plugin** e faça o upload do plugin **Weather Info for WordPress**. Em seguida, ative-o.

6. **Configure a API Key:**
   - No WordPress Admin, vá para **Weather Info**.
   - Adicione sua API Key da OpenWeatherMap.

## Scripts npm

- `npm run build-css`: Compila os arquivos SASS em CSS.
- `npm run watch-css`: Observa mudanças nos arquivos SASS e compila automaticamente para CSS.

## Licença
Este projeto está licenciado sob a licença GPL v3. Veja o arquivo `LICENSE` para mais detalhes.
