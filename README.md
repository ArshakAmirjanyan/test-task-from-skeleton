# MyBank Commission task skeleton

IMPORTANT NOTES ABOUT THE PROJECT

I used the skeleton provided by you, but upgraded php version to 8.1.32, hence some dependencies needed to be updated
too.
THE API PROVIDED FOR RATES DID NOT WORK!!!!!!!!!!!, so I just hardcoded in a fake rate provider class... The interface
can
be extended to create another rate provider class to actually make a call to an API. I assure you that I can use curl
to make requests :D

CURRENT ARCHITECTURE

CURRENTLY I USE FACTORY for creation, Bridge and Strategy for behavior :) The rate provider uses singleton, so that in
case
of an actual API call, it would not make multiple calls thereby slowing down the application. I have several dummy
classes(like a monthly tracker or an excel reader)
to show the extendability of the architecture, their instantiation is done
through factories. For the service and calculators I use Bridge and Strategy patterns to make the appropriate
calculations depending on the current transaction. I tried to structure the application in DDD paradigm :)

NOTES ABOUT THE ARCHITECTURE

The code is highly extendable, since I used no frameworks but pure php, the bindings are done to concretions inside the
index.php file, I could have created a simple DI container, but thought that it will be out of scope for the task
and would be more about creating a custom framework :)

If you feel like I could use abstract factory for the calculators instead of a complex bloated factory, I feel the
same too :D

if you feel like commission free transaction count and amount limit could have been written inside separate rule classes
in Chain of responsibility pattern, I feel the same too :)

Those are ideas that came a bit later to me and I didn't feel like wasting too much time on refactoring the existing
structure as I am already in the last day of the deadline :)

ANOTHER FUN NOTE

Making calculators in singleton would optimize memory usage :)

HOW TO RUN

Run the index.php file inside the src directory and provide it with a file, like the one in test-data folder called
test-input.csv :)

src/index.php path-to-file.csv

Some testcases are provided, including 3 unit tests, 1 integration test and an automation test :)
To run the tests you need to execute:  bin/phpunit 
