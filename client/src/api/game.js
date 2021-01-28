import useHTTP from '../features/useHTTP.js'

class Game
{
    static async startNew()
    {
        const { jsonHeaders } = useHTTP()

        try {
            const response = await fetch(`http://localhost:50846/new-game`, {
                method: 'POST',
                headers: jsonHeaders,
            })

            if (!response.ok) {
                alert(response.statusText)
                return
            }
        } catch (error) {
            console.log(error)
        }
    }
}

export default Game