import useHTTP from '../features/useHTTP.js'

class Answer
{
    static async answerQuestion(data)
    {
        const { jsonHeaders } = useHTTP()

        try {
            const response = await fetch(`http://localhost:50846/answer`, {
                method: 'POST',
                headers: jsonHeaders,
                body: JSON.stringify(data),
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

export default Answer