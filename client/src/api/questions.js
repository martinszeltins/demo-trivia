import useHTTP from '../features/useHTTP.js'

class Questions
{
    static async get()
    {
        const { jsonHeaders } = useHTTP()

        try {
            const response = await fetch(`http://localhost:50846/questions`, {
                method: 'GET',
                headers: jsonHeaders,
            })

            if (!response.ok) {
                alert(response.statusText)
                return
            }

            return await response.json()
        } catch (error) {
            console.log(error)
        }
    }
}

export default Questions