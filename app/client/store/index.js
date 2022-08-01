export const state=() =>({
    'thumbnail_url': process.env.APP_URL+'storage/vehicles/thumbnail/',
    'large_url': process.env.APP_URL+'storage/vehicles/large/'
})

export const mutations={
}

export const actions = {
}

export const getters = {
    stringSearcher: () => (string, query) =>{
        query = query.trim().toLowerCase().split(' ')
        var result = false
        // for(var index in query){
            if(string.toLowerCase().includes(query[index])){
                result = true                    
            }
        // }
        return result
    },
    numFormater: () => price => {
        if(typeof price == 'number'){
            return `${price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')}`
        }
    },
    phoneFormater: () => phone => {
        if(typeof phone == 'number'){
            return `${phone.toString().replace(/\B(?=(\d{4})+(?!\d))/g, ' ')}`
        }
    },
    notEmpty: () => obj => {
        var res = {}
        for (const [key, value] of Object.entries(obj)) {
            if(value){
                res[key] = value
            }
        } 
        return res
    }
}