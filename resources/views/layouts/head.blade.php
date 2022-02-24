<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    const URL_BASE = "{{url('')}}"
</script>
<style>
    .overflow{
        overflow: auto;
    }
    .itemsPage{
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }
    .itemsPage>input{
        width: 50px;
        text-align: center;
    }
    .manual-container{
        display: flex;
        min-height: 94vh;
        justify-content: center;
        align-items: center;
        padding: 5vh 0 0 0;
    }
    .manual-card{
        min-height: 80vh;
    }
    .manual-card-header{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .cursoPointer{
        cursor: pointer;
    }
</style>
